<?php

namespace App\Notifications;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerDocumentStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $seller;
    protected $documentName;
    protected $status;
    protected $comments;

    /**
     * Create a new notification instance.
     */
    public function __construct(Seller $seller, string $documentName, string $status, string $comments = null)
    {
        $this->seller = $seller;
        $this->documentName = $documentName;
        $this->status = $status;
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
        $statusText = $this->status === 'approved' ? 'Approved' : 'Rejected';
        $statusIcon = $this->status === 'approved' ? '✅' : '❌';
        
        $message = (new MailMessage)
            ->subject('Document Verification Update - ' . $statusText)
            ->greeting('Hello ' . $this->seller->name . ',')
            ->line('We have an update regarding your document verification.')
            ->line('**Document:** ' . $this->documentName)
            ->line('**Status:** ' . $statusIcon . ' ' . $statusText);

        if ($this->comments) {
            $message->line('**Reviewer Comments:** ' . $this->comments);
        }

        if ($this->status === 'approved') {
            $message->line('Great news! Your document has been approved.')
                ->line('We are one step closer to completing your seller verification.');
        } else {
            $message->line('Unfortunately, your document needs attention.')
                ->line('Please review the comments above and resubmit the document with the necessary corrections.')
                ->action('Update Your Documents', url('/seller/profile/documents'));
        }

        // Check verification progress
        $progress = $this->seller->getVerificationProgress();
        $message->line('**Verification Progress:** ' . $progress . '% complete');

        if ($progress === 100) {
            $message->line('🎉 All your documents have been approved! Your application is now under final review.');
        }

        return $message->line('Thank you for your patience during the verification process.')
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
            'document_name' => $this->documentName,
            'status' => $this->status,
            'comments' => $this->comments,
            'verification_progress' => $this->seller->getVerificationProgress(),
            'updated_at' => now()->toDateTimeString(),
        ];
    }
}
