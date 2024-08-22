<?php

declare(strict_types=1);

namespace App\Attributes;

use Attribute;

/* Indicate that Attribute will be used only on constants */

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class AttributeProperty
{
    /* Will be useful to retrieve attribute class later */
    public const ATTRIBUTE_PATH = 'App\Attributes\\';

    public function __construct(
        private readonly mixed $value,
    ) {
    }

    /**
     * Get the value of the attribute
     */
    public function get()
    : mixed
    {
        return $this->value;
    }
}
