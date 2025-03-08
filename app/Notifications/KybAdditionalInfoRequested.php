<?php

namespace App\Notifications;

use App\Models\Kyb;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KybAdditionalInfoRequested extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The KYB application instance.
     *
     * @var \App\Models\Kyb
     */
    protected $kyb;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Kyb  $kyb
     * @return void
     */
    public function __construct(Kyb $kyb)
    {
        $this->kyb = $kyb;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Additional Information Required for KYB Application')
            ->greeting("Hello {$notifiable->name},")
            ->line('We need additional information to process your KYB application.')
            ->line('Details:')
            ->line($this->kyb->additional_info_request)
            ->action('Update Application', route('merchant.kyb.update'))
            ->line('Please provide the requested information as soon as possible to continue the verification process.')
            ->line('Thank you for your cooperation!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'kyb_id' => $this->kyb->id,
            'status' => 'additional_info',
            'message' => 'Additional information is required for your KYB application.',
            'details' => $this->kyb->additional_info_request,
        ];
    }
}

