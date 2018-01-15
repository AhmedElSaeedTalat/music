<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
             $table->string("name");
            $table->integer("singers_id")->nullable();
            $table->integer("groupSingers_id")->nullable();
            $table->integer("subscriber_id")->nullable();
            $table->integer("event_id")->nullable();
            $table->string("path");
            $table->integer("album_id")->nullable();
            $table->string("songCover")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
}
