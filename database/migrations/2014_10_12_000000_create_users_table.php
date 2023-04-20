<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('avatar');
            $table->enum('role', ['client', 'livreur', 'admin', 'superAdmin']);
            $table->string('telephone')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('isNotify_1')->default(0);
            $table->boolean('isNotify_2')->default(0);
            $table->boolean('isConnect')->default(0);
            $table->boolean('isActive')->default(0);
            $table->boolean('isDelete')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
