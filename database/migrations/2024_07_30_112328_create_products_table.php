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
            $table->decimal('gross_weight', 5, 3)->default(0.000)->comment('Вес брутто, кг (±4г)');
            $table->decimal('price', 5, 2)->default(0.00)->comment('Себестоимость, руб.коп.');
            $table->boolean('is_active')->default(true)->comment('В продаже или нет');
            $table->foreignId('category_id')->nullable()->comment('Группа товаров');

            $table->string('barcode', 13)->nullable()->comment('Штрих-код пачки');
            $table->string('barcode_box', 14)->nullable()->comment('Штрих-код короба');

            $table->decimal('width', 4, 2)->default(0.00)->comment('Ширина пачки, см');
            $table->decimal('depth', 4, 2)->default(0.00)->comment('Глубина пачки, см');
            $table->decimal('height', 4, 2)->default(0.00)->comment('Высота пачки, см');

            $table->decimal('width_box', 5, 2)->default(0.00)->comment('Ширина короба, см');
            $table->decimal('depth_box', 5, 2)->default(0.00)->comment('Глубина короба, см');
            $table->decimal('height_box', 5, 2)->default(0.00)->comment('Высота короба, см');
            $table->unsignedTinyInteger('capacity')->default(6)->comment('Кол-во пачек в коробе, шт.');
            $table->unsignedTinyInteger('box_in_layer')->default(3)->comment('Кол-во коробов в одном слое, шт.');

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
