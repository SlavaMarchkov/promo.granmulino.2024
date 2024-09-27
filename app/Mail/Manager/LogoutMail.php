<?php

namespace App\Mail\Manager;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LogoutMail extends Mailable
{
    use Queueable, SerializesModels;

    protected User|null $user;

    public function __construct(User|null $user)
    {
        $this->user = $user;
    }

    public function envelope()
    : Envelope
    {
        return new Envelope(
            subject: '[Alert] ' . config('app.name') . ' - Выход менеджера',
        );
    }

    public function content()
    : Content
    {
        return new Content(
            markdown: 'Manager.emails.logout',
            with: [
                'userName' => $this->user?->fullName,
                'userEmail' => $this->user?->email,
            ],
        );
    }

    public function attachments()
    : array
    {
        return [];
    }
}
