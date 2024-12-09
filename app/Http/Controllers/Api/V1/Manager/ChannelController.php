<?php

declare(strict_types=1);

// 08.11.2024 at 20:52:17
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Resources\V1\Channel\ChannelCollection;
use App\Models\Channel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

final class ChannelController extends ApiController
{
    private const CACHE_KEY = 'channels-list-manager';

    public function index()
    : JsonResponse
    {
        $channels = Cache::remember(self::CACHE_KEY, now()->addQuarter(), function () {
            return Channel::all();
        });

        return $this->successResponse(
            new ChannelCollection($channels),
            'success',
            __('crud.channels.all'),
        );
    }
}
