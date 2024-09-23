<?php

use Illuminate\Support\Facades\Route;

/*Route::get('/logout/user', function () {
    return new LogoutMail(auth()->user());
});

Route::get('/login/user', function () {
    return new LoginMail(auth()->user());
});

Route::get('/logout/admin', function () {
    return new AdminLogoutMail(auth('admin')->user());
});

Route::get('/login/admin', function () {
    return new AdminLoginMail(auth('admin')->user());
});*/

Route::get('/{pathMatch}', function () {
    return view('app');
})->where('pathMatch', '.*');
