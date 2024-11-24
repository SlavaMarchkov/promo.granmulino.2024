<?php

declare(strict_types=1);

use App\Models\Customer;
use App\Models\CustomerSupervisor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    : void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->string('name', 64);
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->json('data')->nullable();

            $table->foreignId('region_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->foreignId('user_id')->nullable();

            $table->timestamps();
        });

        Schema::create('customer_supervisors', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Customer::class)
                ->constrained()
                ->cascadeOnUpdate();

            $table->string('name');
            $table->boolean('is_active')->default(true);

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('customer_sellers', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Customer::class)
                ->constrained()
                ->cascadeOnUpdate();

            $table->foreignIdFor(CustomerSupervisor::class)->nullable();

            $table->string('name');
            $table->boolean('is_active')->default(true);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    : void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('customers');
            Schema::dropIfExists('customer_supervisors');
            Schema::dropIfExists('customer_sellers');
        }
    }
};
