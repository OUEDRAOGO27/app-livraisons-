<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeAbonnementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_abonnements', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
		    $table->integer('nbr_jours');
		    $table->float('tarif');
		    $table->string('titre_plan');
		    $table->text('description_plan');
		    $table->text('avantage_plan');
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
        Schema::dropIfExists('type_abonnements');
    }
}
