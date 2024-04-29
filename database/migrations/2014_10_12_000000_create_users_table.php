<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
          $table->string('name');
            $table->enum('is_deleted', ['Y', 'N'])->default('N');
            $table->string('type');
            $table->string('username')->nullable();
            $table->integer('discount');
            $table->string('location');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('image')->nullable();
            $table->string('position')->nullable();
            $table->string('role')->default('2');
            $table->string('company_id')->nullable();
            $table->enum('show_price', ['Y', 'N'])->default('Y');
            $table->enum('customer_type', ['Retailer', 'Wholesaler'])->nullable();
            $table->enum('is_active', ['Y', 'N'])->default('Y');
            $table->enum('is_approved', ['Y', 'N'])->default('N');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('users');
    }
}