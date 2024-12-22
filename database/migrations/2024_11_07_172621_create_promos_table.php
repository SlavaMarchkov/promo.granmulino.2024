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
                StatusEnum::ON_APPROVAL->value,
                StatusEnum::IN_PROCESS->value,
                StatusEnum::WAITING_FOR_REPORT->value,
                StatusEnum::DONE->value,
                StatusEnum::DECLINED->value,
            ])->default(StatusEnum::ON_APPROVAL->value);

            $table->enum('promo_type', [
                TypeEnum::DISCOUNT->value,
                TypeEnum::SALES_PEOPLE_BOOST->value,
                TypeEnum::RETAILERS_BOOST->value,
                TypeEnum::GIFT_FOR_PURCHASE->value,
                TypeEnum::COVERAGE_INCREASE->value,
                TypeEnum::IN_OUT->value,
            ])->nullable()->default(null);

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

            $table->decimal('total_sales_before', 10, 0)->default(0);
            $table->decimal('total_sales_plan', 10, 0)->default(0);
            $table->decimal('total_sales_on_time', 10, 0)->default(0);
            $table->decimal('total_sales_after', 10, 0)->default(0);
            $table->decimal('total_budget_plan', 10, 0)->default(0);
            $table->decimal('total_budget_actual', 10, 0)->default(0);
            $table->decimal('total_promo_profit', 10, 0)->default(0);
            $table->decimal('total_mark', 3, 2)->default(0.00);

            $table->timestamps();
        });

        Schema::create('promo_products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('promo_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable();
            $table->foreignId('product_id')->nullable();

            $table->decimal('sales_before', 10, 0)->default(0);
            $table->decimal('sales_plan', 10, 0)->default(0);
            $table->decimal('sales_after', 10, 0)->default(0);
            $table->decimal('sales_on_time', 10, 0)->default(0);
            $table->decimal('compensation', 5, 2)->default(0);

            $table->decimal('budget_plan', 10, 0)->default(0);
            $table->decimal('budget_actual', 10, 0)->default(0);
            $table->decimal('profit_per_unit', 10, 2)->default(0);
            $table->decimal('promo_profit', 10, 0)->default(0);

            $table->timestamps();
        });

        Schema::create('promo_sellers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('promo_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id');
            $table->foreignId('seller_id');

            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->boolean('is_supervisor')->nullable()->default(false);

            $table->decimal('sales_before', 10, 0)->default(0);
            $table->decimal('sales_plan', 10, 0)->default(0);
            $table->decimal('sales_after', 10, 0)->default(0);
            $table->decimal('surplus_plan', 4, 0)->default(0);
            $table->unsignedSmallInteger('compensation_plan')->default(0);
            $table->unsignedSmallInteger('compensation_actual')->default(0);

            $table->decimal('budget_plan', 10, 0)->default(0);
            $table->decimal('budget_actual', 10, 0)->default(0);

            $table->timestamps();
        });

        Schema::create('promo_marks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('promo_id')->constrained()->cascadeOnDelete();
            $table->decimal('goals', 3, 2)->default(0);
            $table->decimal('sales', 3, 2)->default(0);
            $table->decimal('staff', 3, 2)->default(0);
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
            Schema::dropIfExists('promo_sellers');
            Schema::dropIfExists('promo_marks');
        }
    }
};
