<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('make_id');
            $table->foreign('make_id')->references('id')->on('make')->onDelete('cascade')->onUpdate('cascade');
            $table->string('model_name',80);
            $table->string('model_code');
            $table->string('image');
            $table->enum('is_delete',['N','Y'])->default('N');
            $table->boolean('is_active')->default('1');
            $table->timestamps();
        });
        // Schema::table('model', function (Blueprint $table) {
        //     $table->foreignId('make_id')->reference('id')->on('make_id')->onDelete('cascade')->onUpdate('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model');
    }
}