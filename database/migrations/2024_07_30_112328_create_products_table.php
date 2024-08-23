<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    : void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name', 64);
            $table->unsignedSmallInteger('weight')->comment('Вес в граммах')->default(400);
            $table->decimal('price', 5, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->foreignId('category_id')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    : void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('products');
        }
    }
};
