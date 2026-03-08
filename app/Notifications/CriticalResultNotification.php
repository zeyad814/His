<?php

namespace App\Notifications;

use App\Models\CriticalResult;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CriticalResultNotification extends Notification
{
    use Queueable;

    protected $result;

    /**
     * Create a new notification instance.
     */
    public function __construct(CriticalResult $result)
    {
        $this->result = $result;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'critical_result_id' => $this->result->id,
            'message' => 'Alert: New Critical Result! Test: ' . $this->result->test_type_and_value,
            'clinic' => $this->result->receiving_clinic,
            'action_url' => '/api/doctor/critical-results/show/' . $this->result->id,
        ];
    }
}
