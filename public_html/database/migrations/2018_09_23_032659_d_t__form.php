<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DTForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DT_Form', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("cid_customer");
            $table->integer("cid_supplier");

            $table->string("code")->comment= " Ma so Phieu";
            $table->string("name")->nullable()->comment=" loại văn kiện ";
            $table->string("name_docs")->nullable()->comment=" Tên trong hồ sơ  ";
            $table->string("phone")->nullable();
            $table->string("sobandich")->nullable();
            $table->string("ngaytrahoso")->nullable();
            
            $table->enum("approved",['1','2','3'])->default('1')->comment=" 1:pending,2:ok,3:cancel";

            $table->integer("cid_users");
            
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
        Schema::dropIfExists('DT_Form');
    }
}
