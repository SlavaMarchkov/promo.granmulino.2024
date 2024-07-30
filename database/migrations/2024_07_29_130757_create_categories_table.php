<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    : void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('name', 32);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    : void
    {
        if (!app()->environment('production')) {
            Schema::dropIfExists('categories');
        }
    }
};
