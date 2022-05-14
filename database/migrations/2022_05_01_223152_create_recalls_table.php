<?php

use App\Models\Dispensary;
use App\Models\Grower;
use App\Models\Product;
use App\Models\Recall;
use App\Models\RecallNotice;
use App\Models\Tester;
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
        Schema::create('recalls', function (Blueprint $table) {
            $table->id();
            $table->text('mra_public_notice_url');
            $table->datetime('published_at');
            // An explination of what consumers should do if their product matches the description.
            $table->text('recommended_actions')->nullable();
            $table->integer('type')->nullable();
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();

            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
        Schema::create('recalled_products', function (Blueprint $table){
            $table->string('product_id');
            $table->foreignIdFor(Recall::class);

            $table->unique(['product_id', 'recall_id']);
            $table->foreign('product_id')->references('id')->on('products');
        });
        Schema::create('recalled_dispensaries', function (Blueprint $table){
            $table->foreignIdFor(Dispensary::class);
            $table->foreignIdFor(Recall::class);
        });
        Schema::create('recalled_growers', function (Blueprint $table){
            $table->foreignIdFor(Grower::class);
            $table->foreignIdFor(Recall::class);
        });
        Schema::create('recalled_testers', function (Blueprint $table){
            $table->foreignIdFor(Tester::class);
            $table->foreignIdFor(Recall::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recalls');
    }
};
