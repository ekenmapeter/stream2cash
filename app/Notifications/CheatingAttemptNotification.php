<?php

namespace App\Notifications;

use App\Models\SuspensionOrchestration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CheatingAttemptNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $suspension;

    /**
     * Create a new notification instance.
     */
    public function __construct(SuspensionOrchestration $suspension)
    {
        $this->suspension = $suspension;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $user = $this->suspension->user;
        $video = $this->suspension->video;
        $evidence = $this->suspension->cheat_evidence;

        return (new MailMessage)
            ->subject('🚨 Cheating Attempt Detected - User Suspension Required')
            ->greeting('Admin Alert!')
            ->line('A user has been detected attempting to cheat the video reward system.')
            ->line('**User Details:**')
            ->line("• Name: {$user->name}")
            ->line("• Email: {$user->email}")
            ->line("• User ID: {$user->id}")
            ->line("• Suspension ID: {$this->suspension->id}")
            ->line('**Video Details:**')
            ->line("• Video: " . ($video ? $video->title : 'N/A'))
            ->line("• Reward Amount: ₦" . number_format($this->suspension->amount_involved, 2))
            ->line('**Cheating Evidence:**')
            ->line("• Watch Percentage: " . ($evidence['watch_percentage'] ?? 'N/A') . "%")
            ->line("• Seek Count: " . ($evidence['seek_count'] ?? 'N/A'))
            ->line("• Pause Count: " . ($evidence['pause_count'] ?? 'N/A'))
            ->line("• Tab Visible: " . ($evidence['tab_visible'] ? 'Yes' : 'No'))
            ->line("• Heartbeat Count: " . ($evidence['heartbeat_count'] ?? 'N/A'))
            ->line('**Validation Notes:**')
            ->line(implode("\n• ", $evidence['validation_notes'] ?? []))
            ->line('**Action Required:**')
            ->line('Please review this suspension request and either approve or reject it.')
            ->action('Review Suspension', url('/admin/suspensions/' . $this->suspension->id))
            ->line('**Time:** ' . $this->suspension->created_at->format('Y-m-d H:i:s'))
            ->salutation('Stream2Cash Anti-Cheat System');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'suspension_id' => $this->suspension->id,
            'user_id' => $this->suspension->user_id,
            'user_name' => $this->suspension->user->name,
            'amount_involved' => $this->suspension->amount_involved,
            'suspension_type' => $this->suspension->suspension_type,
        ];
    }
}
