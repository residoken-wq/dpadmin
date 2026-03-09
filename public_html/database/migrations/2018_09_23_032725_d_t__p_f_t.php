<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DTPFT extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DT_PDT', function (Blueprint $table) {
            $table->increments('id');
            $table->string("code")->nullable()->comment=" ten ma hoa ";
            $table->string("name");
            $table->enum("approved",['1','2'])->default('1')->comment="1:created, 2: approved";
            $table->integer("cid_form");
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
        Schema::dropIfExists('DT_PDT');
    }
}
