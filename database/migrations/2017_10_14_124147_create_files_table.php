<?php

use App\Model\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(File::TABLE_NAME, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('target_id')->unsigned(); // Для MySQL 5.0 полиморф не работает
            $table->unsignedTinyInteger('target_type')
                ->default(1)
                ->comment('1 - Post, 2 - User'); // Для MySQL 5.0 метод foreign() не работает
            $table->tinyInteger('hidden')->default(0);
            $table->string('path',180);
            $table->timestamps();
            $table->softDeletes();
        });

        for ($i=0; $i<200; $i++) {
            if (0 === $i%2) {
                $path = 'storage/app/images/bibliarii.jpg';
            } else {
                $path = 'storage/app/images/drednout2.jpg';
            }
            DB::table(File::TABLE_NAME)->insert([
                'target_id' => $i,
                'target_type' => 1,
                'path' => $path,
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
        Schema::dropIfExists(File::TABLE_NAME);
    }
}
