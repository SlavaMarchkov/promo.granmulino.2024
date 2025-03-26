<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports “GD Library” and “Imagick” to process images
    | internally. Depending on your PHP setup, you can choose one of them.
    |
    | Included options:
    |   - \Intervention\Image\Drivers\Gd\Driver::class
    |   - \Intervention\Image\Drivers\Imagick\Driver::class
    |
    */

    'driver' => \Intervention\Image\Drivers\Gd\Driver::class,

    /*
    |--------------------------------------------------------------------------
    | Configuration Options
    |--------------------------------------------------------------------------
    |
    | These options control the behavior of Intervention Image.
    |
    | - "autoOrientation" controls whether an imported image should be
    |    automatically rotated according to any existing Exif data.
    |
    | - "decodeAnimation" decides whether a possibly animated image is
    |    decoded as such or whether the animation is discarded.
    |
    | - "blendingColor" Defines the default blending color.
    */

    'options' => [
        'autoOrientation' => true,
        'decodeAnimation' => true,
        'blendingColor'   => 'ffffff',
    ],

    'no_image'                   => 'no-image.png',
    'path_to_user_images'        => 'app/public/images/user/',
    'path_to_user_thumbnails'    => 'app/public/images/user/thumbnails/',
    'path_to_product_images'     => 'app/public/images/product/',
    'path_to_product_thumbnails' => 'app/public/images/product/thumbnails/',

    /**
     * Ширина сжатой картинки и thumbnail в пикселях
     */
    'default_width'              => 800,
    'default_th_width'           => 100,
];
