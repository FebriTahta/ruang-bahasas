<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKursusUraianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kursus_uraian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kursus_id');
            $table->unsignedBigInteger('uraian_id');
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
        Schema::dropIfExists('kursus_uraian');
    }
}
