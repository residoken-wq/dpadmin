<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FixOrderCustomerNullDefaults extends Migration
{
    /**
     * Run the migrations.
     * Fix database schema: set tong and tamung to default 0 instead of NULL
     *
     * @return void
     */
    public function up()
    {
        // Step 1: Update existing NULL values to 0
        DB::statement('UPDATE DT_Order_Customer SET tamung = 0 WHERE tamung IS NULL');
        DB::statement('UPDATE DT_Order_Customer SET tong = 0 WHERE tong IS NULL');
        
        // Step 2: Alter columns to have default value of 0 (using raw SQL to avoid doctrine/dbal dependency)
        DB::statement('ALTER TABLE DT_Order_Customer MODIFY COLUMN tong INT NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE DT_Order_Customer MODIFY COLUMN tamung INT NOT NULL DEFAULT 0');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE DT_Order_Customer MODIFY COLUMN tong INT NULL DEFAULT NULL');
        DB::statement('ALTER TABLE DT_Order_Customer MODIFY COLUMN tamung INT NULL DEFAULT NULL');
    }
}

