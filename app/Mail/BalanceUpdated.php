<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BalanceUpdated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;
    public float $oldBalance;
    public float $newBalance;
    public string $reason;
    public string $adminName;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, float $oldBalance, float $newBalance, string $reason, string $adminName)
    {
        $this->user = $user;
        $this->oldBalance = $oldBalance;
        $this->newBalance = $newBalance;
        $this->reason = $reason;
        $this->adminName = $adminName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Stream Adolla - Account Balance Updated',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.balance_updated',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
