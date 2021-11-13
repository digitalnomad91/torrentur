<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTorrentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('torrents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('user_id');
            $table->integer('update_user_id');
            $table->string('title', 100);
            $table->string('category_guess', 25);
            $table->string('title_guess', 75);
            $table->text('description');
            $table->integer('views');
            $table->string('tracker_id_csv', 100);
            $table->tinyInteger('tracker_count');
            $table->enum('private', ['yes', 'no']);
            $table->string('comment', 250);
            $table->bigInteger('size');
            $table->string('info_hash', 40)->unique();
            $table->integer('piece_length');
            $table->integer('seeders');
            $table->integer('leechers');
            $table->text('file_list');
            $table->integer('file_count');
            $table->integer('file_id');
            $table->string('torrent_url', 350);
            // $table->string('foreign_table', 50);
            // $table->foreign('foreign_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('torrents');
    }
}


