<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("vendor_id");
            $table->integer("client_id");
            $table->integer("confirmedTicked_id");
            $table->integer("numberTickets");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_datas');
    }
}
