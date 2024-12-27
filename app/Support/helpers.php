<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

const PRODUCT_IMG_HEIGHT = 800;
const PRODUCT_IMG_PATH = '/assets/img/products/';

if (!function_exists('to_boolean')) {
    /**
     * Convert to boolean
     *
     * @param $key
     * @return bool
     */
    function to_boolean($key)
    : bool {
        return filter_var($key, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}

if (!function_exists('convert_string_to_number')) {
    function convert_string_to_number($str)
    : array|string|null {
        $str = str_replace(',', '.', $str);
        return preg_replace('/[^0-9.]/', '', $str);
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
    : string {
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
    : string {
        return Str::upper($code);
    }
}

if (!function_exists('check_item_for_empty_array')) {
    /**
     * Checks form input $item_id and, in case it is an empty array, makes this input null.
     * The function is needed in form request validations when updating an entry.
     *
     * @param mixed $item
     * @return int|string|null
     */
    function check_item_for_empty_array(mixed $item)
    : int|string|null {
        return ((is_array($item) || is_object($item)) && empty($item)) ? null : $item;
    }
}

if (!function_exists('upload_image')) {
    /**
     * Uploads an image as a .webp file
     *
     * @param string $image
     * @return string
     */
    function upload_image(string $image)
    : string {
        $name = md5((string)time()) . '.webp';

        $img = Image::read($image)
            ->scaleDown(PRODUCT_IMG_HEIGHT)
            ->toWebp(80);

        $upload_path = public_path() . PRODUCT_IMG_PATH;
        $img->save($upload_path . $name);

        return $name;
    }
}

if (!function_exists('remove_image')) {
    /**
     * Removes an image
     *
     * @param string|null $image
     * @return void
     */
    function remove_image(string|null $image)
    : void {
        $file = public_path() . PRODUCT_IMG_PATH . $image;
        if (file_exists($file)) {
            @unlink($file);
        }
    }
}
