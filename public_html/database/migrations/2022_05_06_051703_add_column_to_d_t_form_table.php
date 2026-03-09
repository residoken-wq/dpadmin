<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToDTFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('DT_Form') && !Schema::hasColumn('DT_Form', 'event_mail_remind')) {
            Schema::table('DT_Form', function (Blueprint $table) {
                $table->enum("locked", ['0', '1'])->default('0')->comment = " 0:false,1:true";
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('DT_Form') && Schema::hasColumn('DT_Form', 'event_mail_remind')) {
            Schema::table('DT_Form', function (Blueprint $table) {
                $table->dropColumn('locked');
            });
        }
    }
}
