<?php

declare(strict_types=1);

// 21.02.2025 at 21:41:38
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    : void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();

            $table->string('file');
            $table->string('thumbnail');
            $table->morphs('imageable');

            $table->timestamps();
        });
    }

    public function down()
    : void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('images');
        }
    }
};
