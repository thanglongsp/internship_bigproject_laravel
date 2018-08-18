<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('plan_id');
            $table->foreign('plan_id')
                ->references('id')
                ->on('plans');
            $table->integer('parent_id')->nullable()->unsigned();
            $table->foreign('parent_id')
                ->references('id')
                ->on('comments');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');   
            $table->string('checkin_location')->nullable();
            $table->string('picture')->nullable();
            $table->string('content');
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
        Schema::dropIfExists('comments');
    }
}
