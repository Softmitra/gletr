<?php

namespace App\Notifications;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerRegistrationReceived extends Notification implements ShouldQueue
{
    use Queueable;

    protected $seller;

    /**
     * Create a new notification instance.
     */
    public function __construct(Seller $seller)
    {
        $this->seller = $seller;
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
            ->subject('Welcome to ' . config('app.name') . ' - Registration Received!')
            ->greeting('Welcome, ' . $this->seller->name . '!')
            ->line('Thank you for registering as a seller on our platform.')
            ->line('We have received your application and documents for verification.')
            ->line('**Your Registration Details:**')
            ->line('• Business Name: ' . $this->seller->business_name)
            ->line('• Email: ' . $this->seller->email)
            ->line('• Registration Date: ' . $this->seller->created_at->format('M d, Y'))
            ->line('**What happens next?**')
            ->line('1. Our team will review your documents')
            ->line('2. You will receive email updates on the verification progress')
            ->line('3. Once approved, you can start selling immediately')
            ->line('**Verification Timeline:**')
            ->line('• Document Review: 2-3 business days')
            ->line('• Final Approval: 1-2 business days after document approval')
            ->line('We will keep you updated via email throughout the process.')
            ->action('Check Application Status', route('seller.verification.status'))
            ->line('If you have any questions, please don\'t hesitate to contact our support team.')
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
            'registration_date' => $this->seller->created_at->toDateTimeString(),
        ];
    }
}
