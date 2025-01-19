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

            $table->foreignId('user_id')->nullable();
            $table->foreignId('region_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->foreignId('channel_id')->nullable();
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('retailer_id')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longText('comments')->nullable();

            $table->decimal('total_sales_before', 10, 2)->default(0.00)->comment('Общие продажи ДО акции, шт. или руб.');
            $table->decimal('total_sales_plan', 10, 2)->default(0.00)->comment('Общий план продаж ВО ВРЕМЯ акции, шт. или руб.');
            $table->decimal('total_sales_on_time', 10, 2)->default(0.00)->comment('Общие продажи ВО ВРЕМЯ акции, шт. или руб.');
            $table->decimal('total_sales_after', 10, 2)->default(0.00)->comment('Общие продажи ПОСЛЕ акции, шт. или руб.');

            $table->decimal('total_budget_plan', 10, 2)->default(0.00)->comment('Общий план бюджета, руб.коп.');
            $table->decimal('total_budget_actual', 10, 2)->default(0.00)->comment('Общий факт бюджета, руб.коп.');

            $table->decimal('total_promo_profit_plan', 10, 2)->default(0.00)->comment('Общий план прибыли на акцию, руб.коп.');
            $table->decimal('total_promo_profit_actual', 10, 2)->default(0.00)->comment('Общий факт прибыли на акцию, руб.коп.');

            $table->decimal('total_mark', 3, 2)->default(0.00)->comment('Средняя оценка акции, балл');

            $table->timestamps();

            $table->comment('Сводная таблица промо-акций');
        });

        Schema::create('promo_products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('promo_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id');
            $table->foreignId('product_id');

            $table->unsignedSmallInteger('discount')->comment('Величина скидки, %');
            $table->unsignedSmallInteger('net_profit')->comment('Норматив чистой прибыли, %');

            $table->decimal('promo_price', 5, 2)->default(0.00)->comment('Акционная цена, руб.коп.');

            $table->decimal('sales_before', 10, 0)->default(0)->comment('Продажи ДО акции, шт.');
            $table->decimal('sales_plan', 10, 0)->default(0)->comment('План продаж ВО ВРЕМЯ акции, шт.');
            $table->decimal('sales_on_time', 10, 0)->default(0)->comment('Продажи ВО ВРЕМЯ акции, шт.');
            $table->decimal('sales_after', 10, 0)->default(0)->comment('Продажи ПОСЛЕ акции, шт.');

            $table->decimal('compensation', 5, 2)->default(0.00)->comment('Компенсация, руб.коп.');

            $table->decimal('surplus_plan', 5, 2)->default(0.00)->comment('План прироста, %');
            $table->decimal('surplus_actual', 5, 2)->default(0.00)->comment('Факт прироста, %');

            $table->decimal('revenue_plan', 10, 2)->default(0.00)->comment('План выручки, руб.коп.');
            $table->decimal('revenue_actual', 10, 2)->default(0.00)->comment('Факт выручки, руб.коп.');
            $table->decimal('budget_plan', 10, 2)->default(0.00)->comment('План бюджета, руб.коп.');
            $table->decimal('budget_actual', 10, 2)->default(0.00)->comment('Факт бюджета, руб.коп.');

            $table->decimal('profit_per_unit', 10, 2)->default(0.00)->comment('Прибыль на шт., руб.коп.');
            $table->decimal('profit_per_product_plan', 10, 2)->default(0.00)->comment('План прибыли на продукт, руб.коп.');
            $table->decimal('profit_per_product_actual', 10, 2)->default(0.00)->comment('Факт прибыли на продукт, руб.коп.');

            $table->timestamps();

            $table->comment('Детализация скидочной промо-акции для продукта');
        });

        Schema::create('promo_sellers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('promo_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id');
            $table->foreignId('seller_id');

            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->boolean('is_supervisor')->nullable()->default(false);

            $table->decimal('sales_before', 10, 2)->default(0.00)->comment('Продажи ДО акции, руб.коп.');
            $table->decimal('sales_plan', 10, 2)->default(0.00)->comment('План продаж ВО ВРЕМЯ акции, руб.коп.');
            $table->decimal('sales_after', 10, 2)->default(0.00)->comment('Факт продаж ВО ВРЕМЯ акции, руб.коп.');

            $table->decimal('surplus_plan', 5, 2)->default(0.00)->comment('План прироста, %');
            $table->decimal('surplus_actual', 5, 2)->default(0.00)->comment('Факт прироста, %');

            $table->unsignedSmallInteger('compensation')->comment('Компенсация, %');

            $table->decimal('budget_plan', 10, 2)->default(0.00)->comment('План премии, руб.коп');
            $table->decimal('budget_actual', 10, 2)->default(0.00)->comment('Факт премии, руб.коп');

            $table->timestamps();

            $table->comment('Мотивация ТП на продажи');
        });

        Schema::create('promo_marks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('promo_id')->constrained()->cascadeOnDelete();
            $table->decimal('goals', 3, 2)->default(0.00)->comment('Достижение целей акции');
            $table->decimal('sales', 3, 2)->default(0.00)->comment('Оценка за продажи');
            $table->decimal('staff', 3, 2)->default(0.00)->comment('Оценка персонала');
            $table->longText('comments')->nullable();

            $table->timestamps();

            $table->comment('Оценка промо-акции (ставит Sales-Manager)');
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
