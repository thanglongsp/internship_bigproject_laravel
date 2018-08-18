<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_user', function (Blueprint $table) {
            // TODO: primary keys + no timestamps
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('plan_id');
            $table->unsignedInteger('role');
            // = 0 : creator 
            // = 1 : participant
            // = 2 : only follow
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
        Schema::dropIfExists('plan_user');
    }
}
