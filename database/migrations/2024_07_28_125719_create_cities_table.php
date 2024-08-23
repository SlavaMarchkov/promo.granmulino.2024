<?php

declare(strict_types=1);

use App\Models\Region;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    : void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();

            $table->string('name', 64);
            $table->foreignIdFor(Region::class)->nullable();

            $table->unique(['region_id', 'name'], 'city_in_region_unique');

            $table->timestamps();
        });
    }

    public function down()
    : void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('cities');
        }
    }
};
