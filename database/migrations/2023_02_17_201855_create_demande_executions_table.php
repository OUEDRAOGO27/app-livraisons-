<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandeExecutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demande_executions', function (Blueprint $table) {
            $table->id();
            $table->integer('id_liv')->unsigned();
            $table->foreign('id_liv')->references('id')->on('users')->onDelete('cascade');
		    $table->integer('id_dem_liv')->unsigned();
            $table->foreign('id_dem_liv')->references('id')->on('demande_executions')->onDelete('cascade');
		    $table->enum('accord_client',['refuser','accepter','en_cours']);
		    $table->boolean('isActive')->default(0);
            $table->boolean('isDelete')->default(0);
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
        Schema::dropIfExists('demande_executions');
    }
}
