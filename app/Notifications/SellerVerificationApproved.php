<?php

namespace App\Notifications;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerVerificationApproved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $seller;
    protected $comments;

    /**
     * Create a new notification instance.
     */
    public function __construct(Seller $seller, string $comments = null)
    {
        $this->seller = $seller;
        $this->comments = $comments;
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
        $message = (new MailMessage)
            ->subject('🎉 Your Seller Account Has Been Approved!')
            ->greeting('Congratulations, ' . $this->seller->name . '!')
            ->line('We are pleased to inform you that your seller account has been successfully verified and approved.')
            ->line('You can now start selling your products on our platform.')
            ->action('Access Your Dashboard', url('/seller/dashboard'))
            ->line('Here are your account details:')
            ->line('• Business Name: ' . $this->seller->business_name)
            ->line('• Email: ' . $this->seller->email)
            ->line('• Verification Date: ' . now()->format('M d, Y'))
            ->line('You can now:')
            ->line('✓ Add products to your store')
            ->line('✓ Manage your inventory')
            ->line('✓ Process orders')
            ->line('✓ Access seller analytics');

        if ($this->comments) {
            $message->line('**Admin Comments:** ' . $this->comments);
        }

        $message->line('Thank you for choosing our platform. We look forward to a successful partnership!')
            ->salutation('Best regards, The ' . config('app.name') . ' Team');

        return $message;
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
            'verification_date' => now()->toDateTimeString(),
            'comments' => $this->comments,
        ];
    }
}
