<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ordered_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->integer('item_id');
            $table->integer('order_id');
            $table->integer('price');
            $table->string('color');
            $table->text('description');
            $table->string('image1');
            $table->string('image2');
            $table->string('image3');
            $table->boolean('X');
            $table->boolean('L');
            $table->boolean('XL');
            $table->string('type');
            $table->string('status');
            // $table->boolean('notify');
            $table->integer('seller_id');
            $table->integer('buyer_id');
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
