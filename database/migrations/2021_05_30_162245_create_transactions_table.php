<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('amount');
            $table->string('reference')->nullable();
            $table->integer('nominee_id');
            $table->integer('event_id');
            $table->string('status')->nullable();
            $table->string('payment_channel')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('customer_mobile')->nullable();
            $table->string('currency')->nullable();
            $table->datetime('paid_at')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
