<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->text('access_token');
            $table->text('refresh_token');
            $table->integer('vendor_id');
            $table->text('secret');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_tokens');
    }
}
