<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Nombre');
            $table->integer('Capacidad');
            $table->integer('CapacidadMax');
            $table->string('coords_lat');
            $table->string('coords_lng');
            $table->string('QR');
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
        Schema::dropIfExists('locacions');
    }
}
