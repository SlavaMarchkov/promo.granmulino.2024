<?php

use App\Mail\Admin\LoginMail as AdminLoginMail;
use App\Mail\Admin\LogoutMail as AdminLogoutMail;
use App\Mail\Manager\LoginMail;
use App\Mail\Manager\LogoutMail;
use Illuminate\Support\Facades\Route;

Route::get('mailable/logout/user', function () {
    return new LogoutMail(auth()->user());
});

Route::get('mailable/login/user', function () {
    return new LoginMail(auth()->user());
});

Route::get('mailable/logout/admin', function () {
    return new AdminLogoutMail(auth('admin')->user());
});

Route::get('mailable/login/admin', function () {
    return new AdminLoginMail(auth('admin')->user());
});

Route::get('/{pathMatch}', function () {
    return view('app');
})->where('pathMatch', '.*');
