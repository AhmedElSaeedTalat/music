<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TicketsRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TicketsRequests', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("vendors_id");
            $table->integer("numberTickets_adult");
            $table->integer("numberTickets_child");
            $table->integer('user_id')->nullable();
            $table->string('userName')->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('TicketsRequests');
    }
}
