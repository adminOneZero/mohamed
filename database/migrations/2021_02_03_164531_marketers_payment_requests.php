<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MarketersPaymentRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('marketers_payment_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('marketer_id');
            $table->string('phone');
            $table->string('payment_methode');
            $table->string('money');
            $table->boolean('status');
            $table->string('date');
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
