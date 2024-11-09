<?php

declare(strict_types=1);

// 08.11.2024 at 00:26:21
use App\Enums\Promo\StatusEnum;
use App\Enums\Promo\TypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    : void
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();

            $table->enum('status', [
                StatusEnum::ON_APPROVAL->name,
                StatusEnum::IN_PROCESS->name,
                StatusEnum::WAITING_FOR_REPORT->name,
                StatusEnum::DONE->name,
                StatusEnum::DECLINED->name,
            ])->default(StatusEnum::ON_APPROVAL->name);
            $table->enum('promo_type', [
                TypeEnum::DISCOUNT->name,
                TypeEnum::SALES_PEOPLE_BOOST->name,
                TypeEnum::RETAILERS_BOOST->name,
                TypeEnum::GIFT_FOR_PURCHASE->name,
                TypeEnum::COVERAGE_INCREASE->name,
                TypeEnum::IN_OUT->name,
            ]);
            $table->unsignedTinyInteger('discount')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('region_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->foreignId('channel_id')->nullable();
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('retailer_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longText('comments')->nullable();

            $table->timestamps();
        });

        Schema::create('promo_products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('promo_id');
            $table->foreignId('category_id')->nullable();
            $table->foreignId('product_id')->nullable();

            $table->decimal('sales_before', 10, 0)->default(0);
            $table->decimal('sales_plan', 10, 0)->default(0);
            $table->decimal('sales_on_time', 10, 0)->default(0);
            $table->decimal('sales_after', 10, 0)->default(0);
            $table->decimal('compensation', 5, 2)->default(0);

            $table->decimal('budget_plan', 10, 0)->default(0);
            $table->decimal('budget_actual', 10, 0)->default(0);
            $table->decimal('profit_plan', 10, 2)->default(0);
            $table->decimal('profit_actual', 10, 2)->default(0);

            $table->timestamps();
        });

        Schema::create('promo_marks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('promo_id');
            $table->unsignedTinyInteger('goals')->default(0);
            $table->unsignedTinyInteger('sales')->default(0);
            $table->unsignedTinyInteger('outlets')->default(0);
            $table->longText('comments')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    : void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('promos');
            Schema::dropIfExists('promo_products');
            Schema::dropIfExists('promo_marks');
        }
    }
};
