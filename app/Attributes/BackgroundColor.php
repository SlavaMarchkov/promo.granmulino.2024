<?php

declare(strict_types=1);

namespace App\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
final class BackgroundColor extends AttributeProperty
{
    public function __construct(
        private readonly mixed $value,
    ) {
        parent::__construct($this->value);
    }

    /**
     * Get the value of the attribute
     */
    public function get()
    : string
    {
        return 'bg-' . $this->value;
    }
}
