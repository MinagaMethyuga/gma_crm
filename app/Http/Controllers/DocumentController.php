<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    // ─── Admin ────────────────────────────────────────────────────────────────

    public function index()
    {
        $documents = Document::with(['plans', 'uploader'])->latest()->get();
        $plans = Plan::orderBy('name')->get();

        $documentsJson = $documents->map(fn ($d) => [
            'id' => $d->id,
            'title' => $d->title,
            'original_filename' => $d->original_filename,
            'is_public' => $d->is_public,
            'plan_ids' => $d->plans->pluck('id'),
        ]);

        return view('admin.documents.index', compact('documents', 'plans', 'documentsJson'));
    }

    public function store(Request $request)
    {
        $isPublic = $request->boolean('is_public');

        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:51200', // 50 MB
            'is_public' => 'nullable|boolean',
            'plan_ids' => $isPublic ? 'nullable|array' : 'required|array|min:1',
            'plan_ids.*' => 'exists:plans,id',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $mimeType = $file->getMimeType();
        $storedPath = $file->store('documents', 'local');

        $document = Document::create([
            'title' => $request->title,
            'file_path' => $storedPath,
            'original_filename' => $originalName,
            'mime_type' => $mimeType,
            'is_public' => $isPublic,
            'uploaded_by' => $request->user()->id,
        ]);

        $document->plans()->sync($isPublic ? [] : ($request->plan_ids ?? []));

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Document uploaded successfully.',
                'document' => $this->formatDocument($document->load('plans')),
            ]);
        }

        return redirect()->route('admin.documents.index')->with('success', 'Document uploaded successfully.');
    }

    public function update(Request $request, Document $document)
    {
        $isPublic = $request->boolean('is_public');

        $rules = [
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:51200',
            'is_public' => 'nullable|boolean',
            'plan_ids' => $isPublic ? 'nullable|array' : 'required|array|min:1',
            'plan_ids.*' => 'exists:plans,id',
        ];

        $request->validate($rules);

        $data = [
            'title' => $request->title,
            'is_public' => $isPublic,
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data['file_path'] = $file->store('documents', 'local');
            $data['original_filename'] = $file->getClientOriginalName();
            $data['mime_type'] = $file->getMimeType();
        }

        $document->update($data);
        $document->plans()->sync($isPublic ? [] : ($request->plan_ids ?? []));

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Document updated successfully.',
                'document' => $this->formatDocument($document->load('plans')),
            ]);
        }

        return redirect()->route('admin.documents.index')->with('success', 'Document updated successfully.');
    }

    public function destroy(Document $document)
    {
        $document->delete(); // file cleanup handled in model booted()

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Document deleted successfully.']);
        }

        return redirect()->route('admin.documents.index')->with('success', 'Document deleted.');
    }

    // ─── Member ───────────────────────────────────────────────────────────────

    public function memberIndex()
    {
        $user = auth()->user();
        $planId = $user->effectivePlanId();

        if (! $planId) {
            $documents = collect();
        } else {
            $documents = Document::with('plans')
                ->whereHas('plans', fn ($q) => $q->where('plans.id', $planId))
                ->latest()
                ->get();
        }

        return view('member.documents.index', compact('documents'));
    }

    public function show(Document $document)
    {
        $user = auth()->user();
        $planId = $user->effectivePlanId();

        // Authorize: user's plan must be in the document's allowed plans
        $allowed = $planId && $document->plans()->where('plans.id', $planId)->exists();

        if (! $allowed) {
            abort(403, 'You do not have access to this document.');
        }

        return view('member.documents.show', compact('document'));
    }

    public function stream(Document $document): StreamedResponse
    {
        $user = auth()->user();
        $planId = $user->effectivePlanId();

        // Authorize: user's plan must be in the document's allowed plans
        $allowed = $planId && $document->plans()->where('plans.id', $planId)->exists();

        if (! $allowed) {
            abort(403, 'You do not have access to this document.');
        }

        // Stream from private disk
        if (! Storage::disk('local')->exists($document->file_path)) {
            abort(404, 'Document file not found.');
        }

        return Storage::disk('local')->response(
            $document->file_path,
            $document->original_filename,
            [
                'Content-Type' => $document->mime_type,
                'Content-Disposition' => 'inline; filename="'.$document->original_filename.'"',
                'Cache-Control' => 'no-store, no-cache, must-revalidate',
                'Pragma' => 'no-cache',
                'X-Frame-Options' => 'SAMEORIGIN',
            ]
        );
    }

    // ─── Public ───────────────────────────────────────────────────────────────

    public function publicIndex()
    {
        $documents = Document::where('is_public', true)->latest()->get();

        return view('research-insights', compact('documents'));
    }

    public function publicShow(Document $document)
    {
        if (! $document->is_public) {
            abort(404);
        }

        return view('research-insights.show', compact('document'));
    }

    public function publicStream(Document $document): StreamedResponse
    {
        if (! $document->is_public) {
            abort(404);
        }

        if (! Storage::disk('local')->exists($document->file_path)) {
            abort(404, 'Document file not found.');
        }

        return Storage::disk('local')->response(
            $document->file_path,
            $document->original_filename,
            [
                'Content-Type' => $document->mime_type,
                'Content-Disposition' => 'inline; filename="'.$document->original_filename.'"',
                'Cache-Control' => 'no-store, no-cache, must-revalidate',
                'Pragma' => 'no-cache',
                'X-Frame-Options' => 'SAMEORIGIN',
            ]
        );
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function formatDocument(Document $document): array
    {
        return [
            'id' => $document->id,
            'title' => $document->title,
            'original_filename' => $document->original_filename,
            'mime_type' => $document->mime_type,
            'is_public' => $document->is_public,
            'is_pdf' => $document->isPdf(),
            'icon' => $document->getIconClass(),
            'icon_color' => $document->getIconColor(),
            'plans' => $document->plans->map(fn ($p) => ['id' => $p->id, 'name' => $p->name]),
            'uploaded_by' => $document->uploader?->name,
            'created_at' => $document->created_at->format('M d, Y'),
        ];
    }
}
