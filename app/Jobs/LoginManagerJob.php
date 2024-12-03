<?php

declare(strict_types=1);

// 03.12.2024 at 12:47:46
namespace App\Jobs;

use App\Mail\Manager\LoginMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

final class LoginManagerJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly User $user,
    ) {
    }

    public function handle()
    : void
    {
        Mail::to(config('mail.to.admin'))->send(new LoginMail($this->user));
    }
}
