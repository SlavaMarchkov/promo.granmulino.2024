<?php

namespace App\Mail\Admin;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LogoutMail extends Mailable
{
    use Queueable, SerializesModels;

    protected Admin|null $admin;

    public function __construct(Admin|null $admin)
    {
        $this->admin = $admin;
    }

    public function envelope()
    : Envelope
    {
        return new Envelope(
            subject: '[Alert] ' . config('app.name') . ' - Выход администратора',
        );
    }

    public function content()
    : Content
    {
        return new Content(
            markdown: 'Admin.emails.logout',
            with: [
                'name' => $this->admin?->name,
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
