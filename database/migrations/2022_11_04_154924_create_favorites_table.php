<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->comment('ユーザID');
            $table->unsignedBigInteger('post_id')->comment('ツイートID');

            $table->index('id');
            $table->index('user_id');
            $table->index('post_id');

            $table->unique([
                'user_id',
                'post_id'
            ]);

            $table->foreign('user_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
