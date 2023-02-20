<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandeLivraisonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demande_livraisons', function (Blueprint $table) {
            $table->id();
            $table->integer('id_client')->unsigned();
            $table->foreign('id_client')->references('id')->on('users')->onDelete('cascade');
		    $table->integer('id_type_liv')->unsigned();
            $table->foreign('id_type_liv')->references('id')->on('type_livraisons')->onDelete('cascade');
		    $table->float('long_depart');
		    $table->float('lat_depart');
		    $table->string('libelle_depart');
		    $table->float('long_arrive');
		    $table->float('lat_arrive');
		    $table->string('libelle_arrive');
		    $table->string('poids_colis');
		    $table->integer('quantite_colis');
		    $table->string('taille_colis');
		    $table->timestamp('date_livraison');
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
        Schema::dropIfExists('demande_livraisons');
    }
}
