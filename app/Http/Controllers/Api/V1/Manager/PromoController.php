<?php

declare(strict_types=1);

// 08.11.2024 at 00:24:23
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

final class PromoController extends ApiController
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
