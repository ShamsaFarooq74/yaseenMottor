<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('portname');
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->string('price');
            $table->boolean('portcontainer')->default('0');
            $table->boolean('roro')->default('0');
            $table->boolean('insurance')->default('0');
            $table->boolean('warranty')->default('0');
            $table->string('insurance_price')->nullable();
            $table->string('warranty_price')->nullable();
            $table->boolean('is_active')->default('1');
           $table->enum('is_delete', array('N','Y'))->default('N');
            // $table->boolean('inspection')->default('0');
            // $table->boolean('certificate')->default('0');
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
        Schema::dropIfExists('shipments');
    }
}