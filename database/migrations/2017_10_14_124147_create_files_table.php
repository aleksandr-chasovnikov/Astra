<?php

use App\Model\File;
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
                ->comment('1 - Post, 2 - User'); // Для MySQL 5.0 метод foreign() не работает
            $table->tinyInteger('hidden')->default(0);
            $table->string('path',180);
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
        Schema::dropIfExists(File::TABLE_NAME);
    }
}
