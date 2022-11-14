<?php

use App\Models\Dispensary;
use App\Models\Grower;
use App\Models\Tester;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->unique()->index();
            $table->string('name')->nullable();
            $table->foreignIdFor(Dispensary::class, 'dispensary_id')->nullable();
            $table->foreignIdFor(Dispensary::class, 'grower_id')->nullable();
            $table->foreignIdFor(Dispensary::class, 'tester_id')->nullable();
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
        Schema::dropIfExists('products');
    }
};
