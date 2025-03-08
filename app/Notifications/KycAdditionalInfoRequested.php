<?php

namespace App\Notifications;

use App\Models\Kyc;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KycAdditionalInfoRequested extends Notification implements ShouldQueue
{
    use Queueable;

    protected $kyc;
    protected $requestDetails;

    /**
     * Create a new notification instance.
     */
    public function __construct(Kyc $kyc, string $requestDetails)
    {
        $this->kyc = $kyc;
        $this->requestDetails = $requestDetails;
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
        return (new MailMessage)
            ->subject('Additional Information Required for KYC Verification')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We need additional information to complete your KYC verification.')
            ->line($this->requestDetails)
            ->action('Update Your Application', route('kyc.update'))
            ->line('Please provide this information as soon as possible to avoid delays in processing your application.')
            ->line('Thank you for your cooperation.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'KYC Additional Information Required',
            'message' => 'Please provide additional information for your KYC verification.',
            'details' => $this->requestDetails,
            'kyc_id' => $this->kyc->id,
            'link' => route('kyc.update')
        ];
    }
}

