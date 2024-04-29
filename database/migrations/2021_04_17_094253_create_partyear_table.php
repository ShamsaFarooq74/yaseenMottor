<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartyearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partyear', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('model_id');
            $table->foreign('model_id')->references('id')->on('model')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('min_year');
            $table->foreign('min_year')->references('id')->on('year')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('max_year');
            $table->foreign('max_year')->references('id')->on('year')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('part_id');
            $table->foreign('part_id')->references('id')->on('parts')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('partyear');
    }
}
