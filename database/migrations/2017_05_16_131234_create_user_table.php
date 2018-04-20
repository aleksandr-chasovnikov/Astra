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
            $table->integer('region', false, true)->default(0);
            $table->integer('avatar', false, true)->default(0);
//            $table->enum('role', ['admin', 'manager', 'vip', 'user'])
//                ->default('user');
            $table->unsignedTinyInteger('role')->default(1)
                ->comment('1-user, 2-manger, 3-admin, 4-vip');
            $table->string('name', 120);
            $table->string('email', 120);
            $table->string('password', 120);
            $table->rememberToken();
            $table->integer('phone', false, true)->default(0);
            $table->integer('promo_order', false, true)->default(0);
            $table->tinyInteger('banned')->default(0);
            $table->tinyInteger('verified')->default(0);
            $table->string('email_token')->default('');
            $table->string('site', 120)->default('');
            $table->string('skype', 120)->default('');
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