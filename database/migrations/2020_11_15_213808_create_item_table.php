<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Items', function (Blueprint $table) {
            $table->id();
            $table->string('price');
            $table->string('color');
            $table->text('description');
            $table->string('image1');
            $table->string('image2');
            $table->string('image3');
            $table->boolean('X')->nullable();
            $table->boolean('L')->nullable();
            $table->boolean('XL')->nullable();
            $table->boolean('view');
            $table->string('type');
            $table->timestamps();
            $table->foreignId('seller_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Items');
    }
}
