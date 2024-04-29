<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('make_id');
            $table->foreign('make_id')->references('id')->on('make')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('model_id');
            $table->foreign('model_id')->references('id')->on('model')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('year_id');
            $table->foreign('year_id')->references('id')->on('year')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('steering')->default('0');
            $table->string('price');
            $table->boolean('featured')->default('0');
            $table->boolean('stock_status')->default('0');
            $table->integer('user_id'); //remove//
            $table->string('products_name');//remove//
            $table->string('unit');//remove//
            $table->string('description',65535);//rsemove//
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
        Schema::dropIfExists('products');
    }
}