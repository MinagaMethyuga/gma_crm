<?php

namespace App\Http\Controllers;

use App\Models\CommunityGroupMessage;
use App\Models\DirectMessage;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Serves chat image attachments behind an access check.
 *
 * Chat photos are stored on the private `local` disk (not the webroot-backed
 * `public` disk), so the only way to read one is through these routes, which
 * verify the viewer is a member of the group or a friend in the conversation.
 * The random storage filename is never enough on its own.
 */
class ChatImageController extends Controller
{
    public function communityImage(CommunityGroupMessage $message): StreamedResponse
    {
        abort_unless($message->image, 404);

        $groupId = $message->community_group_id;

        $isMember = auth()->user()
            ->communityGroups()
            ->where('community_groups.id', $groupId)
            ->exists();

        abort_unless($isMember, 403);

        return $this->stream($message->image);
    }

    public function directImage(DirectMessage $message): StreamedResponse
    {
        abort_unless($message->image, 404);

        $me = auth()->id();

        // Only the two participants may read the attachment.
        $isParticipant = $message->sender_id === $me || $message->receiver_id === $me;
        abort_unless($isParticipant, 403);

        return $this->stream($message->image);
    }

    private function stream(string $path): StreamedResponse
    {
        if (! Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->response($path, null, [
            // Attachments are user uploads: never let the browser sniff a
            // script content type out of them, and keep them off the CDN.
            'Content-Type' => $this->mimeFor($path),
            'Content-Disposition' => 'inline',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, max-age=300',
        ]);
    }

    private function mimeFor(string $path): string
    {
        return match (strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            default => 'image/jpeg',
        };
    }
}
