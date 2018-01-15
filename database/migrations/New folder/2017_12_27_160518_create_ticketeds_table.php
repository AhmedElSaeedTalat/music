<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticketeds', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->text("ticketNumber");
            $table->integer("vendors_id");
            $table->integer('user_id');
            $table->string('ticket_type');
            $table->string('visitor_email');
            $table->string('visitor_name');
            $table->string('event_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticketeds');
    }
}
