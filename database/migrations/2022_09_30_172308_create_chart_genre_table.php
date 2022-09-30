<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartGenreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chart_genre', function (Blueprint $table) {
        $table->integer('chart_id')->unsigned();    //students,subjectsテーブルのidが
        $table->integer('genre_id')->unsigned();    //bigIncrementであった場合はbigIntegerにする
        $table->primary(['chart_id', 'genre_id']);  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chart_genre');
    }
}
