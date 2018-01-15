<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHandleVendorRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handle_vendor_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('vendorName');
            $table->string('address');
            $table->string('email');
            $table->integer('sellingRate');
            $table->string('request_proccess')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('handle_vendor_requests');
    }
}
