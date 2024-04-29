<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('manufacturer');
            $table->string('model');
            $table->string('battery')->nullable();
            $table->timestamp('last_active_time')->nullable();
            $table->string('app_version')->nullable();
            $table->string('platform');
            $table->string('serial')->nullable();
            $table->string('uuid')->nullable();
            $table->string('version')->nullable();
            $table->string('token')->nullable();
            $table->enum('status', ['A', 'D'])->default('A');
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
        Schema::dropIfExists('user_devices');
    }
}