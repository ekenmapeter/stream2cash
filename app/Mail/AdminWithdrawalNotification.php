<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class AdminWithdrawalNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;
    public Withdrawal $withdrawal;

    public function __construct(User $user, Withdrawal $withdrawal)
    {
        $this->user = $user;
        $this->withdrawal = $withdrawal;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Withdrawal Request Pending Review',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.withdrawal_admin',
        );
    }
}


