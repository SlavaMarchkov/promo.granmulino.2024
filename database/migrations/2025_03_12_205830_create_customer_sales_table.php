<?php

declare(strict_types=1);

// 12.03.2025 at 20:58:30
use App\Models\Category;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    : void
    {
        Schema::create('customer_sales', function (Blueprint $table) {
            $table->id();

            $table->integer('sales_plan');
            $table->integer('sales_actual')->default(0);
            $table->date('sales_date');
            $table->string('comments')->nullable();

            $table->foreignIdFor(User::class)->nullable();
            $table->foreignIdFor(Customer::class)->constrained('customers');
            $table->foreignIdFor(Category::class)->constrained('categories');

            $table->timestamps();
        });
    }

    public function down()
    : void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('customer_sales');
        }
    }
};
