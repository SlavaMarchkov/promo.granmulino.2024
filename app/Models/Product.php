<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\ProductObserver;
use App\Traits\Models\HasPreviousNext;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    use HasPreviousNext;

    protected $fillable = [
        'name',
        'code', // код продукта в 1С
        'weight', // вес одной пачки
        'gross_weight', // вес брутто одной пачки
        'price',
        'is_active',
        'category_id',
        'barcode',
        'barcode_box',
        'width',
        'depth',
        'height',
        'width_box',
        'depth_box',
        'height_box',
        'capacity', // кол-во пачек в коробе
        'boxes_in_layer',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function packSize()
    : Attribute
    {
        return new Attribute(
            get: function () {
                return $this->width * $this->depth * $this->height;
            },
        );
    }

    public function boxSize()
    : Attribute
    {
        return new Attribute(
            get: function () {
                return $this->width_box * $this->depth_box * $this->height_box;
            },
        );
    }

    public function boxWeight()
    : Attribute
    {
        return new Attribute(
            get: function () {
                return ($this->capacity * $this->weight) / 1_000;
            },
        );
    }

    public function category()
    : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function customers()
    : BelongsToMany
    {
        return $this->belongsToMany(
            Customer::class,
            'customer_product',
            'customer_id',
            'product_id',
        );
    }

    public function images()
    : MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function mainImage()
    : Image|Model|null
    {
        return $this->images()->get()->filter(function (Image $image) {
            return $image->is_main;
        })->first();
    }
}
