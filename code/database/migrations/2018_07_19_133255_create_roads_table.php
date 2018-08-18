<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plan_id')->nullable()->unsigned();
            $table->foreign('plan_id')
                ->references('id')
                ->on('plans');
            $table->integer('order_number');
            $table->string('start_place');
            $table->string('end_place');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('vehicle')->nullable();
            $table->string('action');
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
        Schema::dropIfExists('roads');
    }
}
