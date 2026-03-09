<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DTLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DT_Log', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->comment=" Tên nguowif  thực hiện ";
            $table->string("actions")->comment=" Làm gì ";
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
        Schema::dropIfExists('DT_Log');
    }
}
