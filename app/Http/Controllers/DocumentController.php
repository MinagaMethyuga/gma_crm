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
        $plans     = Plan::orderBy('name')->get();

        return view('admin.documents.index', compact('documents', 'plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'file'     => 'required|file|mimes:pdf|max:51200', // 50 MB
            'plan_ids' => 'required|array|min:1',
            'plan_ids.*' => 'exists:plans,id',
        ]);

        $file          = $request->file('file');
        $originalName  = $file->getClientOriginalName();
        $mimeType      = $file->getMimeType();
        $storedPath    = $file->store('documents', 'local');

        $document = Document::create([
            'title'             => $request->title,
            'file_path'         => $storedPath,
            'original_filename' => $originalName,
            'mime_type'         => $mimeType,
            'uploaded_by'       => $request->user()->id,
        ]);

        $document->plans()->sync($request->plan_ids);

        if ($request->wantsJson()) {
            return response()->json([
                'message'  => 'Document uploaded successfully.',
                'document' => $this->formatDocument($document->load('plans')),
            ]);
        }

        return redirect()->route('admin.documents.index')->with('success', 'Document uploaded successfully.');
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
        $planId = $user->plan_id;

        if (!$planId) {
            $documents = collect();
        } else {
            $documents = Document::with('plans')
                ->whereHas('plans', fn($q) => $q->where('plans.id', $planId))
                ->latest()
                ->get();
        }

        return view('member.documents.index', compact('documents'));
    }

    public function show(Document $document)
    {
        $user   = auth()->user();
        $planId = $user->plan_id;

        // Authorize: user's plan must be in the document's allowed plans
        $allowed = $document->plans()->where('plans.id', $planId)->exists();

        if (!$allowed) {
            abort(403, 'You do not have access to this document.');
        }

        return view('member.documents.show', compact('document'));
    }

    public function stream(Document $document): StreamedResponse
    {
        $user   = auth()->user();
        $planId = $user->plan_id;

        // Authorize: user's plan must be in the document's allowed plans
        $allowed = $document->plans()->where('plans.id', $planId)->exists();

        if (!$allowed) {
            abort(403, 'You do not have access to this document.');
        }

        // Stream from private disk
        if (!Storage::disk('local')->exists($document->file_path)) {
            abort(404, 'Document file not found.');
        }

        return Storage::disk('local')->response(
            $document->file_path,
            $document->original_filename,
            [
                'Content-Type'        => $document->mime_type,
                'Content-Disposition' => 'inline; filename="' . $document->original_filename . '"',
                'Cache-Control'       => 'no-store, no-cache, must-revalidate',
                'Pragma'              => 'no-cache',
                'X-Frame-Options'     => 'SAMEORIGIN',
            ]
        );
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function formatDocument(Document $document): array
    {
        return [
            'id'                => $document->id,
            'title'             => $document->title,
            'original_filename' => $document->original_filename,
            'mime_type'         => $document->mime_type,
            'is_pdf'            => $document->isPdf(),
            'icon'              => $document->getIconClass(),
            'icon_color'        => $document->getIconColor(),
            'plans'             => $document->plans->map(fn($p) => ['id' => $p->id, 'name' => $p->name]),
            'uploaded_by'       => $document->uploader?->name,
            'created_at'        => $document->created_at->format('M d, Y'),
        ];
    }
}
