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
            $table->integer('categories_id')->unsigned()->default(0);
            $table->integer('region', false, true)->unsigned()->default(0);
            $table->integer('photo', false, true)->default(0);
            $table->string('title', 150);
            $table->text('content', 2000);
            $table->tinyInteger('type')->default(0)
                ->comment('0-предложение, 1-спрос');
            $table->tinyInteger('hidden')->default(0);
//            $table->enum('type', ['offer', 'demand']);    // неподходит для старый версий mysql
            $table->integer('promo_order')->default(0)->comment('vip-сортировка');
            $table->integer('price',false, true)->default(0);
            $table->string('user_name', 120)->default('');
            $table->string('city', 120)->default('');
            $table->string('email', 120)->default('');
            $table->integer('phone', false, true)->default(0);
            $table->string('site', 120)->default('');
            $table->string('skype', 120)->default('');
            $table->tinyInteger('end_lifetime',false,true)->default(0)
                ->comment('0 - 2 недели, 1 - 4 недели, 2 - 8 недель');
            $table->string('password', 120)->default('');
            $table->string('link')->default('');
            $table->integer('viewed')->default(0);
            $table->string('meta_desc', 180)->default('');
            $table->string('meta_key', 180)->default('');
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
