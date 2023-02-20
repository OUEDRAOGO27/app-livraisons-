<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminDroitDeletesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_droit_deletes', function (Blueprint $table) {
            $table->id();
            $table->integer('id_admin')->unsigned();
            $table->foreign('id_admin')->references('id')->on('users')->onDelete('cascade');
		    $table->string('droit_delete');
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
        Schema::dropIfExists('admin_droit_deletes');
    }
}
