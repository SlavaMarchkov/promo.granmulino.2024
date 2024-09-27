<?php

namespace App\Mail\Admin;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginMail extends Mailable
{
    use Queueable, SerializesModels;

    protected User|null $admin;

    public function __construct(User|null $admin)
    {
        $this->admin = $admin;
    }

    public function envelope()
    : Envelope
    {
        return new Envelope(
            subject: '[Alert] ' . config('app.name') . ' - Вход для администратора',
        );
    }

    public function content()
    : Content
    {
        return new Content(
            markdown: 'Admin.emails.login',
            with: [
                'name' => $this->admin?->display_name,
                'email' => $this->admin?->email,
            ],
        );
    }

    public function attachments()
    : array
    {
        return [];
    }
}
