<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicos_especialidades', function (Blueprint $table) {
            $table->unsignedBigInteger('medicos_id');
            $table->unsignedBigInteger('especialidades_id');

            $table->foreign('medicos_id')->references('id')->on('medicos')->onDelete('cascade');
            $table->foreign('especialidades_id')->references('id')->on('especialidades')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicos_especialidades');
    }
};
