<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('booking_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('operation_id')->unsigned();
            $table->integer('cf_id')->unsigned();
            $table->integer('cu_id')->unsigned();
            $table->foreign('operation_id')->references('id')->on('operation_types')->onDelete('cascade');
            $table->foreign('cf_id')->references('id')->on('collection_files')->onDelete('cascade');
            $table->foreign('cu_id')->references('id')->on('user_collections')->onDelete('cascade');
            $table->timestamps();
        });

    }


    public function down()
    {
        Schema::dropIfExists('booking_histories');
    }
};
