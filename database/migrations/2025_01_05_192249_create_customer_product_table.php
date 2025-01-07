<?php

declare(strict_types=1);

// 05.01.2025 at 19:22:49
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    : void
    {
        Schema::create('customer_product', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Customer::class)->constrained('customers');
            $table->foreignIdFor(Product::class)->constrained('products');
            $table->foreignId('category_id');
            $table->decimal('customer_price', 5, 2)
                ->nullable()
                ->default(null);
            $table->boolean('is_listed')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    : void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('customer_product');
        }
    }
};
