<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref_no');
            $table->decimal('price_off', 8, 2)->nullable();
            $table->date('reg_no');
            $table->string('sub_ref_no');
            $table->string('engine_size');
            $table->unsignedBigInteger('make_id');
            $table->foreign('make_id')->references('id')->on('make')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('body_type_id');
            $table->foreign('body_type_id')->references('id')->on('part_body_types')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('model_id');
            $table->foreign('model_id')->references('id')->on('model')->onDelete('cascade')->onUpdate('cascade');
            $table->date('manufacturer');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->string('steering');
            $table->string('engine_code');
            $table->string('color');
            $table->string('chasis');
            $table->string('version');
            $table->string('m3');
            $table->string('dimension');
             $table->unsignedBigInteger('fuel_id');
            $table->foreign('fuel_id')->references('id')->on('fuel_types')->onDelete('cascade')->onUpdate('cascade');
            $table->string('mileage');
            $table->string('weight');
            $table->string('load_cap');
            $table->string('seats');
            $table->string('door');
            $table->string('drivetrain');
            $table->enum('transmission', array('automatic','manual'))->default('automatic');
            $table->double('price');
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currency')->onDelete('cascade')->onUpdate('cascade');
            $table->string('image');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default('1');
            $table->enum('is_delete', array('N','Y'))->default('N');
            $table->string('is_stock')->default('0');
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
        Schema::dropIfExists('parts');
    }
}