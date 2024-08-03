<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    : void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();

            $table->string('name', 32);
            $table->string('email', 64)->unique();
            $table->string('password', 128);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_super')->default(false);
            $table->timestamp('logged_in_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    : void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('admins');
        }
    }
};
