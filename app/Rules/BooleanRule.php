<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BooleanRule implements ValidationRule
{
    /**
     * @param string $attribute - например "is_active"
     * @param mixed $value - например false
     * @param Closure $fail - сообщение в случае непрохождения валидации
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail)
    : void {
        if (!is_bool(to_boolean($value))) {
            $fail('Значение поля ":attribute" должно быть true или false.');
        }
    }
}
