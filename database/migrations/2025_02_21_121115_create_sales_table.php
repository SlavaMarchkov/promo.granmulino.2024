<?php

declare(strict_types=1);

// 21.02.2025 at 12:11:15
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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->integer('sales_plan')->nullable();
            $table->integer('sales_actual')->nullable();
            $table->date('sales_date');
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
            Schema::dropIfExists('sales');
        }
    }
};
