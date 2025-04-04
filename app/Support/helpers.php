<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

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
    function convert_string_to_number(mixed $str)
    : array|string|null {
        $str = (string)$str;
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
     * @param UploadedFile|string $image
     * @param string $path
     * @param int $width
     * @return string
     */
    function upload_image(UploadedFile|string $image, string $path, int $width)
    : string {
        $name = md5(uniqid('img_', true)) . '.webp';

        $img = Image::read($image)
            ->scaleDown($width)
            ->toWebp(80);

        $upload_dir = storage_path($path);

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $img->save($upload_dir . $name);

        return $name;
    }
}

if (!function_exists('upload_thumbnail')) {
    /**
     * Uploads an image thumbnail as a .jpg file
     *
     * @param UploadedFile|string $image
     * @param string $file
     * @param string $path
     * @return string
     */
    function upload_thumbnail(UploadedFile|string $image, string $file, string $path)
    : string {
        $filename_without_ext = pathinfo($file, PATHINFO_FILENAME);
        $name = 'th_' . $filename_without_ext . '.jpg';

        $img = Image::read($image)
            ->scaleDown(config('image.default_th_width'))
            ->toJpeg(80);

        $upload_dir = storage_path($path);

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $img->save($upload_dir . $name);

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
        $file = storage_path() . '/' . config('image.path_to_product_images') . $image;
        if (file_exists($file)) {
            @unlink($file);
        }
    }
}

if (!function_exists('remove_thumbnail')) {
    /**
     * Removes a thumbnail
     *
     * @param string|null $thumbnail
     * @return void
     */
    function remove_thumbnail(string|null $thumbnail)
    : void {
        $file = storage_path() . '/' . config('image.path_to_product_thumbnails') . $thumbnail;
        if (file_exists($file)) {
            @unlink($file);
        }
    }
}

if (!function_exists('formatNumberRU')) {
    function formatNumberRU(mixed $value)
    : string {
        $num = (float)($value);
        return $num ? number_format($num, 0, '.', ' ') : '';
    }
}

if (!function_exists('formatNumberEN')) {
    function formatNumberEN(mixed $value)
    : string {
        $num = (float)($value);
        return $num ? number_format($num, 0, '.', ',') : '';
    }
}
