<?php

namespace App\Notifications;

use App\Models\Kyc;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KycStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $kyc;
    protected $previousStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Kyc $kyc, string $previousStatus)
    {
        $this->kyc = $kyc;
        $this->previousStatus = $previousStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('KYC Verification Status Update')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('There has been an update to your KYC verification status.');

        switch ($this->kyc->status) {
            case 'approved':
                $message->line('Congratulations! Your KYC verification has been approved.')
                    ->line('Your account now has full access to all features.')
                    ->action('View Details', route('kyc.dashboard'));
                break;

            case 'rejected':
                $message->line('Unfortunately, your KYC verification has been rejected.')
                    ->line('Reason: ' . ($this->kyc->rejection_reason ?: 'No specific reason provided.'))
                    ->line('You can submit a new application with updated information.')
                    ->action('Submit New Application', route('kyc.apply'));
                break;

            case 'kiv':
                $message->line('Your KYC verification is currently under additional review.')
                    ->line('We may require additional information from you.')
                    ->line('Please check your status page for more details.')
                    ->action('View Status', route('kyc.dashboard'));
                break;

            default:
                $message->line('Your application is being processed.')
                    ->line('Please check your status page for more details.')
                    ->action('View Status', route('kyc.dashboard'));
        }

        return $message->line('Thank you for using our service.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'KYC Verification Update',
            'message' => $this->getNotificationMessage(),
            'kyc_id' => $this->kyc->id,
            'previous_status' => $this->previousStatus,
            'current_status' => $this->kyc->status,
            'link' => route('kyc.dashboard')
        ];
    }

    protected function getNotificationMessage(): string
    {
        switch ($this->kyc->status) {
            case 'approved':
                return 'Your KYC verification has been approved.';
            case 'rejected':
                return 'Your KYC verification has been rejected.';
            case 'kiv':
                return 'Your KYC verification is under additional review.';
            default:
                return 'Your KYC verification status has been updated.';
        }
    }
}

