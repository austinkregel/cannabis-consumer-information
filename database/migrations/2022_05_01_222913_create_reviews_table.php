<?php

use App\Models\Dispensary;
use App\Models\Grower;
use App\Models\Product;
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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->string('metrc_id')->nullable();
            $table->datetime('purchased_at')->nullable();
            $table->string('product_id')->nullable();
            $table->foreignIdFor(Dispensary::class)->nullable();
            $table->foreignIdFor(Grower::class)->nullable();
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
        Schema::dropIfExists('reviews');
    }
};
