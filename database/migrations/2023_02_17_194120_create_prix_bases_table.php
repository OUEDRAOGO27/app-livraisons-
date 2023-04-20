<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrixBasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prix_bases', function (Blueprint $table) {
            $table->id();
            $table->integer('prix');
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
        Schema::dropIfExists('prix_bases');
    }
}
