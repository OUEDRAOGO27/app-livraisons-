<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoteLivreursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_livreurs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_client')->unsigned();
            $table->foreign('id_client')->references('id')->on('users')->onDelete('cascade');
            $table->integer('id_liv')->unsigned();
            $table->foreign('id_liv')->references('id')->on('users')->onDelete('cascade');
		    $table->integer('notes');
            $table->string('commentaire');
            $table->boolean('isNotify_1')->default(0);
            $table->boolean('isNotify_2')->default(0);
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
        Schema::dropIfExists('note_livreurs');
    }
}
