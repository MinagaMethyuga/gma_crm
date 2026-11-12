<?php

namespace App\Notifications;

use App\Models\CommunityGroupMessage;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CommunityGroupReportNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly User $reporter,
        private readonly CommunityGroupMessage $message,
        private readonly string $groupName,
        private readonly string $reason,
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
            'type' => 'group_report',
            'sender_id' => $this->reporter->id,
            'sender_name' => $this->reporter->name,
            'sender_avatar' => $this->reporter->avatarUrl(),
            'message' => 'reported a message in '.$this->groupName,
            'preview' => mb_substr($this->reason.': '.$preview, 0, 120),
        ];
    }
}
