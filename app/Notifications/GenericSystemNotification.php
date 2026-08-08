<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GenericSystemNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $eventType;
    public $titleAr;
    public $titleEn;
    public $messageAr;
    public $messageEn;
    public $extraData;

    public function __construct(
        string $eventType,
        string $titleAr,
        string $titleEn,
        string $messageAr,
        string $messageEn,
        array $extraData = []
    ) {
        $this->eventType = $eventType;
        $this->titleAr = $titleAr;
        $this->titleEn = $titleEn;
        $this->messageAr = $messageAr;
        $this->messageEn = $messageEn;
        $this->extraData = $extraData;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'event_type' => $this->eventType,
            'title_ar' => $this->titleAr,
            'title_en' => $this->titleEn,
            'message_ar' => $this->messageAr,
            'message_en' => $this->messageEn,
            'extra_data' => $this->extraData,
        ];
    }
}
