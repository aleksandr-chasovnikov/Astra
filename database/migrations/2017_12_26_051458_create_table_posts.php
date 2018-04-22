<?php

use App\libraries\GenerateText;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        Schema::create('posts', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->default(0);
            $table->integer('region_id', false, true)->unsigned()->default(0);
            $table->string('title', 150);
            $table->text('content', 2000);
            $table->tinyInteger('type')->default(0)
                ->comment('0-предложение, 1-спрос');
            $table->tinyInteger('hidden')->default(0);
//            $table->enum('type', ['offer', 'demand']);    // неподходит для старый версий mysql
            $table->integer('promo_order')->default(0)->comment('vip-сортировка');
            $table->string('price', 20)->default(0);
            $table->string('user_name', 120)->default('-');
            $table->string('city', 120)->default('-');
            $table->string('email', 120)->default('-');
            $table->string('phone', 25)->default('-');
            $table->string('site', 120)->default('-');
            $table->string('skype', 120)->default('-');
            $table->tinyInteger('end_lifetime', false, true)->default(0)
                ->comment('0 - 2 недели, 1 - 4 недели, 2 - 8 недель');
            $table->string('password', 120)->default('-');
            $table->string('link')->default('-');
            $table->integer('viewed')->default(0);
            $table->string('meta_desc', 180)->default('-');
            $table->string('meta_key', 180)->default('-');
            $table->timestampsTz();
            $table->softDeletes();
        });

        for ($i = 0; $i < 500; $i++) {

            DB::table('posts')->insert([
                'category_id' => random_int(20, 170),
                'region_id' => random_int(1, 20),
                'title' => GenerateText::wordFromDonorText(random_int(3, 11)),
                'content' => GenerateText::wordFromDonorText(random_int(5, 120)),
                'price' => random_int(10, 100000000),
                'user_name' => GenerateText::wordFromRandChar(),
                'email' => GenerateText::wordFromRandChar(),
                'city' => GenerateText::wordFromRandChar(),
                'phone' => rand(999000000, 999000000000),
                'site' => GenerateText::wordFromRandChar(),
                'skype' => GenerateText::wordFromRandChar(),
                'password' => '1234567',
                'link' => GenerateText::wordFromRandChar(),
                'viewed' => random_int(1, 9000),
                'meta_desc' => GenerateText::wordFromDonorText(random_int(3, 11)),
                'meta_key' => GenerateText::wordFromDonorText(random_int(3, 11)),
                'created_at' => Carbon::now(),
            ]);
        }
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
