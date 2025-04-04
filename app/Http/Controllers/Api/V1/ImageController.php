<?php

declare(strict_types=1);

// 30.03.2025 at 13:06:20
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Image\StoreProductImageRequest;
use App\Http\Requests\Image\StoreUserImageRequest;
use App\Http\Resources\V1\Product\ProductFullResource;
use App\Http\Resources\V1\User\UserResource;
use App\Models\Product;
use App\Models\User;
use App\Services\Products\ProductService;
use App\Services\Users\UserService;
use Illuminate\Http\JsonResponse;

final class ImageController extends ApiController
{

    public function __construct(
        private readonly ProductService $productService,
        private readonly UserService $userService,
    ) {
    }

    public function uploadProductImages(StoreProductImageRequest $request, Product $product)
    : JsonResponse
    {
        $data = $request->validated();
        $images = $data['images'];

        foreach ($images as $image) {
            $file = upload_image(
                $image,
                config('image.path_to_product_images'),
                config('image.default_width')
            );
            $thumbnail = upload_thumbnail(
                $image,
                $file,
                config('image.path_to_product_thumbnails')
            );
            $this->productService->storeProductImage($file, $thumbnail, $product->id, Product::class, false);
        }

        $product = $this->productService->findProduct($product);

        return $this->successResponse(
            new ProductFullResource($product->load('images')),
            'success',
            __('crud.products.updated'),
        );
    }

    public function uploadUserImages(StoreUserImageRequest $request, User $user)
    : JsonResponse
    {
        $data = $request->validated();
        $images = $data['images'];

        foreach ($images as $image) {
            $file = upload_image(
                $image,
                config('image.path_to_user_images'),
                config('image.default_width')
            );
            $thumbnail = upload_thumbnail(
                $image,
                $file,
                config('image.path_to_user_thumbnails')
            );
            $this->userService->storeUserImage($file, $thumbnail, $user->id, User::class);
        }

        $user = $this->userService->findUser($user);

        return $this->successResponse(
            new UserResource($user->load('images')),
            'success',
            __('crud.users.updated'),
        );
    }

    public function upload()
    {
        return response()->noContent();
    }
}
