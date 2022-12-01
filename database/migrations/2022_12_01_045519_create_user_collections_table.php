<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('user_collections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('property');
            $table->integer('user_id')->unsigned();
            $table->integer('collection_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('cascade');
            $table->timestamps();

        });
    }


    public function down()
    {
        Schema::dropIfExists('user_collections');
    }
};
