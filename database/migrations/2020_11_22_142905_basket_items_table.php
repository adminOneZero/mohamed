<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BasketItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('basket', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id');
            $table->integer('buyer_id');
            $table->integer('seller_id');
            $table->integer('quantity');
            $table->string('selectedColor')->nullable();
            $table->string('selectedSize')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
