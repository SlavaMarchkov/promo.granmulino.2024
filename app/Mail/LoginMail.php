<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginMail extends Mailable
{
    use Queueable, SerializesModels;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function envelope()
    : Envelope
    {
        return new Envelope(
            subject: 'Manager Login',
        );
    }

    public function content()
    : Content
    {
        return new Content(
            markdown: 'emails.login',
            with: [
                'userName' => $this->user->fullName,
                'userEmail' => $this->user->email,
            ],
        );
    }

    public function attachments()
    : array
    {
        return [];
    }
}
