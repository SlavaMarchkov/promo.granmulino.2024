<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CyrillicCharsRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail)
    : void {
        $re = '/^[А-ЯЦцУуШшЩщФфЫыРрЭэЧчТтЬьЮюЪъХхЁа-яё\s-]+$/i';
        if (!preg_match($re, $value, $matches, PREG_OFFSET_CAPTURE)) {
            $fail('messages.auth.cyrillic_rule')->translate();
        }
    }
}
