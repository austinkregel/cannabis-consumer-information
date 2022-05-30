<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strains', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('slug')->index();
            // If we import the data from somewhere, we should credit the source.
            $table->string('based_on_source', 2048)->nullable();
            $table->string('photo_url', 2048)->nullable();
            $table->string('genetics')->nullable();
            $table->string('aprox_thc')->nullable();
            $table->string('aprox_cbd')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('strains');
    }
};
