<?php

declare(strict_types=1);

// 08.11.2024 at 20:52:17
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Resources\V1\ChannelCollection;
use App\Models\Channel;
use Illuminate\Http\JsonResponse;

final class ChannelController extends ApiController
{
    public function index()
    : JsonResponse
    {
        $channels = Channel::all();

        return $this->successResponse(
            new ChannelCollection($channels),
            'success',
            __('crud.channels.all'),
        );
    }
}
