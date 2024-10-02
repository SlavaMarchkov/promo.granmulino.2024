<?php

declare(strict_types=1);

use Illuminate\Support\Str;

if (!function_exists('to_boolean')) {
    /**
     * Convert to boolean
     *
     * @param $key
     * @return boolean
     */
    function to_boolean($key)
    : bool
    {
        return filter_var($key, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}

if (!function_exists('process_name')) {
    /**
     * Make string Uppercase with lowercase for the rest: Example from EXAMPLE etc.
     *
     * @param $name
     * @return string
     */
    function process_name($name)
    : string
    {
        return Str::ucfirst(Str::lower(Str::squish($name)));
    }
}

if (!function_exists('process_code')) {
    /**
     * Make string Uppercase: EXAMPLE
     *
     * @param $code
     * @return string
     */
    function process_code($code)
    : string
    {
        return Str::upper($code);
    }
}

if (!function_exists('check_id_for_empty_array')) {
    /**
     * Checks form input $item_id and, in case it is an empty array, makes this input null.
     * The function is needed in form request validations when updating an entry.
     *
     * @param mixed $item_id
     * @return int|string|null
     */
    function check_id_for_empty_array(mixed $item_id)
    : int|string|null
    {
        return (is_array($item_id) && empty($item_id)) ? null : $item_id;
    }
}
