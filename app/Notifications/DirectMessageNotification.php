<?php

namespace App\Notifications;

use App\Models\DirectMessage;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DirectMessageNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly User $sender, private readonly DirectMessage $message) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        // E2E rows carry no server-readable body, so the preview stays generic
        // rather than leaking plaintext it never had.
        if ($this->message->isEncrypted()) {
            $preview = 'sent you a private message';
        } else {
            $preview = trim((string) $this->message->message);
            if ($this->message->image && $preview === '') {
                $preview = 'sent you a photo';
            }
        }

        return [
            'type' => 'direct_message',
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'sender_avatar' => $this->sender->avatarUrl(),
            'message' => 'sent you a private message',
            'preview' => mb_substr($preview, 0, 80),
        ];
    }
}
