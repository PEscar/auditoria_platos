<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sede_id');
            $table->date('fecha');
            $table->smallInteger('turno')->comment('1: Mañana | 2: Tarde');
            $table->foreignId('sector_id');
            $table->foreignId('responsable_id');
            $table->text('comentario')->nullable();
            $table->timestamps();

            $table->foreign('sede_id')->references('id')->on('sedes');
            $table->foreign('responsable_id')->references('id')->on('users');
            $table->foreign('sector_id')->references('id')->on('sectores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auditorias');
    }
}
