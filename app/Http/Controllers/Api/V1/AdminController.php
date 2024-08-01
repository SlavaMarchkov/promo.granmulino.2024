<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

final class AdminController extends Controller
{
    public function index()
    {
        return Admin::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email'     => ['required', 'email', 'max:254'],
            'password'  => ['required'],
            'name'      => ['required'],
            'is_active' => ['boolean'],
            'abilities' => ['required'],
        ]);

        return Admin::create($data);
    }

    public function show(Admin $admin)
    {
        return $admin;
    }

    public function update(Request $request, Admin $admin)
    {
        $data = $request->validate([
            'email'     => ['required', 'email', 'max:254'],
            'password'  => ['required'],
            'name'      => ['required'],
            'is_active' => ['boolean'],
            'abilities' => ['required'],
        ]);

        $admin->update($data);

        return $admin;
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return response()->json();
    }
}
