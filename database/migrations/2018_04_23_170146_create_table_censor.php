<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCensor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('censor', function (Blueprint $table) {
            $table->increments('id');
            $table->string('word', 120);
            $table->unsignedTinyInteger('status')->default(1);
        });

        foreach (config('') as $word) {
            DB::table('censor')->insert([
                'word' => $word,
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
        //
    }
}
