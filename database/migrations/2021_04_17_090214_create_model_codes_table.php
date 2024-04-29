<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id');
            $table->foreign('model_id')->references('id')->on('model')->onDelete('cascade')->onUpdate('cascade');
            $table->string('model_code',80);
            $table->boolean('is_active')->default('1');
            $table->boolean('is_delete')->default('0');
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
        Schema::dropIfExists('model_codes');
    }
}