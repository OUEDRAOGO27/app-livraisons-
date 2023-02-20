<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpirationAbonnementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expiration_abonnements', function (Blueprint $table) {
            $table->id();
            $table->integer('id_abon')->unsigned();
            $table->foreign('id_abon')->references('id')->on('abonnements')->onDelete('cascade');
		    $table->boolean('status')->default(0);
		    $table->timestamp('date_expire');
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
        Schema::dropIfExists('expiration_abonnements');
    }
}
