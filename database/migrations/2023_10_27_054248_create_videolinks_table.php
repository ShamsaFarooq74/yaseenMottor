<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideolinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videolinks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('part_id');
            $table->foreign('part_id')->references('id')->on('parts')->onDelete('cascade')->onUpdate('cascade');
            $table->string('videolink');
            $table->timestamps();
        });
        
    }
    public function partDetail()
    {
        return $this->belongsTo(PartDetails::class, 'part_id', 'id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videolinks');
    }
}
