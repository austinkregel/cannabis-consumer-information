<?php

use App\Models\User;
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
        Schema::create('growers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('license_number')->nullable();
            $table->string('address')->nullable();
            $table->string('url')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            // Owner?
            $table->foreignIdFor(User::class)->nullable();
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
        Schema::dropIfExists('growers');
    }
};
