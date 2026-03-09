<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DTOrderSupplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DT_Order_Supplier', function (Blueprint $table) {
                $table->increments('id');
        
                $table->integer("cid_supplier");
                $table->integer("cid_form");

                $table->integer("phidichthuat")->nullable();
                $table->integer("congchung")->nullable();
                $table->integer("daucongty")->nullable();
                $table->integer("saoy")->nullable();
                $table->integer("ngoaivu")->nullable();
                $table->integer("phivanchuyen")->nullable();
                $table->integer("vat")->nullable();
                $table->integer("tong")->nullable();
                $table->integer("tamung")->nullable();
                $table->integer("conglai")->nullable();

                $table->enum("approved",['1','2','3'])->default("1")->comment=" 1: created, 2: approved, 3: cancel ";


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
        Schema::dropIfExists('DT_Order_Supplier');
    }
}
