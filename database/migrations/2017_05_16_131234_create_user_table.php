<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('role', ['admin', 'manager', 'user'])
                ->default('user');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('password');
            $table->string('email_token')->nullable();
            $table->boolean('verified')->default(0);
            $table->integer('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->string('site')->nullable();
            $table->string('skype')->nullable();
            $table->integer('balance')->nullable();
            $table->integer('promo_order,')->default(0);
            $table->boolean('banned')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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