<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonnementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->integer('id_liv')->unsigned();
            $table->foreign('id_liv')->references('id')->on('users')->onDelete('cascade');
		    $table->integer('id_type_abon')->unsigned();
            $table->foreign('id_type_abon')->references('id')->on('type_abonnements')->onDelete('cascade');
		    $table->enum('status_abon',['pas_encors_encours','en_cours','expirer']);
            $table->boolean('isNotify_abon_val_1')->default(0);
            $table->boolean('isNotify_abon_val_2')->default(0);
            $table->boolean('isNotify_abon_exp_1')->default(0);
            $table->boolean('isNotify_abon_exp_2')->default(0);
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
        Schema::dropIfExists('abonnements');
    }
}
