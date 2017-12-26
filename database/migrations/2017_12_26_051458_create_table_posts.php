<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('content')->nullable();
            $table->enum('type', ['offer', 'demand']);
            $table->integer('categories_id')->unsigned()->default(1);
            $table->integer('promo_order')->default(0);
            $table->string('img')->nullable();
            $table->string('avatar')->nullable();
            $table->integer('price')->default(0);
            $table->string('user_name')->nullable();
            $table->string('city')->nullable();
            $table->string('email')->nullable();
            $table->integer('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('site')->nullable();
            $table->string('skype')->nullable();
            $table->timestamp('lifetime')->nullable();
            $table->string('password')->nullable();
            $table->string('link')->nullable();
            $table->boolean('hidden')->default(0);
            $table->string('meta_desc')->nullable();
            $table->string('meta_key')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
