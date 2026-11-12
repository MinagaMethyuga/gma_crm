<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class MemberNotificationController extends Controller
{
    /**
     * Lists notifications, newest first by default.
     *
     * Pass ?since=<ISO8601> to get everything from that moment onwards
     * (oldest first). The bell polls with this so a delivered message can raise
     * a toast without re-sending the user's whole history every few seconds.
     *
     * The cursor is created_at rather than id on purpose: `id` is a UUID, so
     * `where id > ?` would compare random strings and silently skip messages.
     */
    public function index(Request $request)
    {
        $since = null;
        if ($raw = $request->query('since')) {
            try {
                $since = Carbon::parse($raw);
            } catch (\Throwable $e) {
                $since = null;
            }
        }

        $query = auth()->user()->notifications();

        if ($since) {
            // reorder() drops the `latest()` the notifications() relation already
            // applies, otherwise its `created_at desc` wins and the cursor page
            // comes back newest-first, defeating arrival ordering.
            //
            // The bound is inclusive and the client overlaps by a second,
            // because notifications can share a timestamp with the cursor.
            // It dedupes the repeats by id.
            $query->reorder()
                ->where('created_at', '>=', $since)
                ->orderBy('created_at')
                ->orderBy('id');
        } else {
            $query->orderByDesc('created_at')->limit(30);
        }

        $notifications = $query
            ->get()
            ->map(function (DatabaseNotification $n) {
                return [
                    'id' => $n->id,
                    'read' => $n->read_at !== null,
                    'type' => data_get($n->data, 'type'),
                    'data' => $n->data,
                    'created_at' => $n->created_at?->toIso8601String(),
                ];
            });

        // max() hands back a raw column string, so it has to be parsed before it
        // can be formatted. Reported even when this page is empty, otherwise the
        // client cursor could never start for a member with a fresh inbox.
        $latestAt = auth()->user()->notifications()->max('created_at');

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => auth()->user()->unreadNotifications()->count(),
            'latest_created_at' => $latestAt ? Carbon::parse($latestAt)->toIso8601String() : null,
        ]);
    }

    public function unreadCount()
    {
        return response()->json(['count' => auth()->user()->unreadNotifications()->count()]);
    }

    public function readAll()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);

        return response()->json(['ok' => true]);
    }

    public function markRead(DatabaseNotification $notification)
    {
        auth()->user()->notifications()
            ->whereKey($notification->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['ok' => true]);
    }

    public function destroy(DatabaseNotification $notification)
    {
        auth()->user()->notifications()->whereKey($notification->id)->delete();

        return response()->json(['ok' => true]);
    }
}
