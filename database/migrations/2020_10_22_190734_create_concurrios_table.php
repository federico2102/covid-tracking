<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConcurriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concurrios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('entrada');
            $table->timestamp('salida')->nullable();
            $table->foreignId('userId')->references('id')->on('users');
            $table->foreignId('locacionId')->references('id')->on('locacions');
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concurrios');
    }
}
