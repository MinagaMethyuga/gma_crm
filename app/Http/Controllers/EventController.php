<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['attendees.user'])->withCount(['attendees as registered_count' => function ($q) {
            $q->where('status', 'registered');
        }])->latest()->get();

        $eventsJson = $events->map(fn($e) => $this->formatEvent($e))->values();

        return view('admin.events.index', compact('events', 'eventsJson'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'cover_image' => 'nullable|image|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'address' => 'nullable|string|max:255',
            'hall_name' => 'nullable|string|max:255',
            'has_seating_capacity' => 'boolean',
            'seating_capacity' => 'nullable|required_if:has_seating_capacity,true|integer|min:1',
            'event_type' => 'required|in:gma,other',
            'website_link' => 'nullable|required_if:event_type,other|url',
        ]);

        $validated['user_id'] = $request->user()->id;
        $validated['has_seating_capacity'] = $request->boolean('has_seating_capacity');

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')
                ->store('events', 'public');
        }

        $event = Event::create($validated);

        return response()->json([
            'message' => 'Event created successfully.',
            'event' => $this->formatEvent($event),
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'cover_image' => 'nullable|image|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'address' => 'nullable|string|max:255',
            'hall_name' => 'nullable|string|max:255',
            'has_seating_capacity' => 'boolean',
            'seating_capacity' => 'nullable|required_if:has_seating_capacity,true|integer|min:1',
            'event_type' => 'required|in:gma,other',
            'website_link' => 'nullable|required_if:event_type,other|url',
        ]);

        $validated['has_seating_capacity'] = $request->boolean('has_seating_capacity');

        if ($request->hasFile('cover_image')) {
            if ($event->cover_image) {
                Storage::disk('public')->delete($event->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')
                ->store('events', 'public');
        }

        $event->update($validated);

        return response()->json([
            'message' => 'Event updated successfully.',
            'event' => $this->formatEvent($event->fresh()),
        ]);
    }

    public function destroy(Event $event)
    {
        if ($event->cover_image) {
            Storage::disk('public')->delete($event->cover_image);
        }

        $event->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Event deleted successfully.']);
        }

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }

    private function formatEvent(Event $event): array
    {
        $registeredCount = $event->registered_count ?? $event->registeredCount();
        $attendeesList = $event->relationLoaded('attendees')
            ? $event->attendees->filter(fn($a) => $a->status === 'registered')->map(fn($a) => [
                'name' => $a->user->name ?? 'Member',
                'email' => $a->user->email ?? '',
                'registered_at' => $a->registered_at?->format('Y-m-d H:i:s') ?? $a->created_at->format('Y-m-d H:i:s'),
                'avatar' => $a->user ? $a->user->avatarUrl() : '',
            ])->values()->all()
            : [];

        return [
            'id' => $event->id,
            'title' => $event->title,
            'cover_image_url' => $event->cover_image ? asset('storage/' . $event->cover_image) : null,
            'start_date' => $event->start_date->toIso8601String(),
            'start_date_formatted' => $event->start_date->format('M d, Y'),
            'start_time_formatted' => $event->start_date->format('g:i A'),
            'end_date' => $event->end_date?->toIso8601String(),
            'end_date_formatted' => $event->end_date?->format('M d, Y g:i A'),
            'address' => $event->address,
            'hall_name' => $event->hall_name,
            'event_type' => $event->event_type,
            'website_link' => $event->website_link,
            'has_seating_capacity' => $event->has_seating_capacity,
            'seating_capacity' => $event->seating_capacity,
            'registered_count' => $registeredCount,
            'is_full' => $registeredCount > 0 && $event->has_seating_capacity && $event->seating_capacity && $registeredCount >= $event->seating_capacity,
            'day' => $event->start_date->format('d'),
            'month' => $event->start_date->format('M'),
            'user_id' => $event->user_id,
            'attendees' => $attendeesList,
        ];
    }
}
