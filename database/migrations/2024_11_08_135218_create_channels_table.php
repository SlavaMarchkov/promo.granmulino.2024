<?php

declare(strict_types=1);

// 08.11.2024 at 20:52:18
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    : void
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();

            $table->string('slug', 255);
            $table->string('name', 64);

            $table->timestamps();
        });
    }

    public function down()
    : void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('channels');
        }
    }
};
