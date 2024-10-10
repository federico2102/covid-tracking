<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVictimasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('victimas', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('victima_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('victima_id')->references('id')->on('users');
            $table->timestamp('entrada');
            $table->primary(['user_id', 'victima_id','entrada']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('victimas');
    }
}
