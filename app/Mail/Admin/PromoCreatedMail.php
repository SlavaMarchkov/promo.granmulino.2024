<?php

declare(strict_types=1);

// 03.12.2024 at 16:32:46
namespace App\Mail\Admin;

use App\Models\Promo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PromoCreatedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly Promo $promo,
    ) {
    }

    public function envelope()
    : Envelope
    {
        return new Envelope(
            subject: '[Alert] ' . config('app.name') . ' - Новая промо-акция',
        );
    }

    public function content()
    : Content
    {
        return new Content(
            markdown: 'Admin.emails.promo-created',
            with: [
                'promo' => $this->promo
            ]
        );
    }

    public function attachments()
    : array
    {
        return [];
    }
}
