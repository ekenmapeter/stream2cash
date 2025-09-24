<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomVerifyEmail extends BaseVerifyEmail
{
    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $url = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(Lang::get('StreamAdolla 🎬 Verify Your Email'))
            ->view('emails.verify_email', [
                'actionUrl' => $url,
                'user' => $notifiable,
                'appName' => config('app.name', 'StreamAdolla'),
            ]);
    }
}


