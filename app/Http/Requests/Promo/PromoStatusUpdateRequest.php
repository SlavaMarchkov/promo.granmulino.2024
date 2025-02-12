<?php

declare(strict_types=1);

// 08.11.2024 at 00:26:21
namespace App\Http\Requests\Promo;

use App\Enums\Promo\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;

final class PromoStatusUpdateRequest extends FormRequest
{
    public function authorize()
    : bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules()
    : array
    {
        return [
            'status'  => ['required', 'in:' . StatusEnum::keys()],
        ];
    }
}
