<?php

declare(strict_types=1);

// 03.12.2024 at 13:30:07
namespace App\Jobs;

use App\Mail\Manager\LogoutMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

final class LogoutManagerJob implements ShouldQueue
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
        info('User ID={id} just logged out.', ['id' => $this->user->id]);
        Mail::to(config('mail.to.admin'))->send(new LogoutMail($this->user));
    }
}
