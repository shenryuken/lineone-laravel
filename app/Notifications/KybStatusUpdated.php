<?php

namespace App\Notifications;

use App\Models\Kyb;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KybStatusUpdated extends Notification implements ShouldQueue
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
        $status = ucfirst(str_replace('_', ' ', $this->kyb->status));
        $message = new MailMessage;
        $message->subject("KYB Application Status: {$status}");
        $message->greeting("Hello {$notifiable->name},");

        if ($this->kyb->status === 'approved') {
            $message->line('Congratulations! Your KYB application has been approved.');
            $message->line('You can now proceed with using our platform\'s full features for your business.');
        } elseif ($this->kyb->status === 'rejected') {
            $message->line('We regret to inform you that your KYB application has been rejected.');
            $message->line('Reason: ' . $this->kyb->rejection_reason);
            $message->line('If you believe this is an error or would like to submit a new application, please contact our support team.');
        }

        $message->action('View Application', route('merchant.kyb.view', $this->kyb));
        $message->line('Thank you for choosing our platform!');

        return $message;
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
            'status' => $this->kyb->status,
            'message' => $this->getStatusMessage(),
        ];
    }

    /**
     * Get the status message based on the KYB status.
     *
     * @return string
     */
    protected function getStatusMessage()
    {
        switch ($this->kyb->status) {
            case 'approved':
                return 'Your KYB application has been approved.';
            case 'rejected':
                return 'Your KYB application has been rejected.';
            default:
                return 'Your KYB application status has been updated.';
        }
    }
}

