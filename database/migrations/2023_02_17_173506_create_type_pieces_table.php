<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypePiecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_pieces', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
		    $table->integer('nbr_face_img');
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
        Schema::dropIfExists('type_pieces');
    }
}
