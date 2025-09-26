<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserVideoCompleted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;
    public Video $video;
    public float $amount;

    public function __construct(User $user, Video $video, float $amount)
    {
        $this->user = $user;
        $this->video = $video;
        $this->amount = $amount;
    }

    public function build()
    {
        return $this->subject('StreamAdolla - Task Completed: '.$this->video->title)
            ->view('emails.user.video-completed')
            ->with([
                'user' => $this->user,
                'video' => $this->video,
                'amount' => $this->amount,
                'balance' => (float) $this->user->balance,
            ]);
    }
}


