<?php

declare(strict_types=1);

use App\Enums\Retailer\TypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    : void
    {
        Schema::create('retailers', function (Blueprint $table) {
            $table->id();

            $table->string('name', 64);
            $table->enum('type', ['local', 'regional', 'federal'])->default(TypeEnum::LOCAL->value);
            $table->text('description')->nullable();
            $table->json('data')->nullable();

            $table->boolean('is_active')->default(true);
            $table->boolean('is_direct')->default(false);

            $table->foreignId('customer_id')->nullable();
            $table->foreignId('city_id')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    : void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('retailers');
        }
    }
};
