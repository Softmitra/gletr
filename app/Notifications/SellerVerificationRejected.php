<?php

namespace App\Notifications;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerVerificationRejected extends Notification implements ShouldQueue
{
    use Queueable;

    protected $seller;
    protected $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct(Seller $seller, string $reason)
    {
        $this->seller = $seller;
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
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
        return (new MailMessage)
            ->subject('Seller Account Verification Update')
            ->greeting('Hello ' . $this->seller->name . ',')
            ->line('We regret to inform you that your seller account verification has been rejected.')
            ->line('**Reason for rejection:**')
            ->line($this->reason)
            ->line('**What you can do next:**')
            ->line('• Review the rejection reason carefully')
            ->line('• Update your documents or information as needed')
            ->line('• Resubmit your application for review')
            ->action('Update Your Application', url('/seller/register'))
            ->line('**Need Help?**')
            ->line('If you have questions about the rejection or need assistance, please contact our support team.')
            ->line('We are here to help you succeed on our platform.')
            ->salutation('Best regards, The ' . config('app.name') . ' Team');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'seller_id' => $this->seller->id,
            'seller_name' => $this->seller->name,
            'business_name' => $this->seller->business_name,
            'rejection_date' => now()->toDateTimeString(),
            'reason' => $this->reason,
        ];
    }
}
