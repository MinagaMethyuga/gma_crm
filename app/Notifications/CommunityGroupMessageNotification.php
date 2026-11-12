<?php

namespace App\Notifications;

use App\Models\CommunityGroupMessage;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CommunityGroupMessageNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly User $sender,
        private readonly CommunityGroupMessage $message,
        private readonly string $groupName,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $preview = trim($this->message->message);
        if ($this->message->image && $preview === '') {
            $preview = 'sent a photo';
        }

        return [
            'type' => 'group_message',
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'sender_avatar' => $this->sender->avatarUrl(),
            'message' => 'sent a message in '.$this->groupName,
            'preview' => mb_substr($preview, 0, 80),

            // Lets the notification deep-link straight into the conversation.
            'group_id' => $this->message->community_group_id,
            'group_name' => $this->groupName,
        ];
    }
}
