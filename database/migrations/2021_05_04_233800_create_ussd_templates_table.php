<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUssdTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ussd_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('user_id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('input_type')->nullable();
            $table->text('options');
            $table->integer('order_in_variable');
            $table->tinyInteger('required')->default(0);
            $table->integer('min_length')->default(0);
            $table->integer('max_length')->default(20);
            $table->string('default_value')->nullable();
            $table->boolean('hidden_text')->default(false);
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
        Schema::dropIfExists('ussd_templates');
    }
}
