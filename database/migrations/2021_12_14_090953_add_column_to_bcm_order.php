<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToBcmOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bcm_order', function (Blueprint $table) {
            $table->dateTime('order_date')->after('order_number');
            $table->date('customer_date_of_birth')->nullable()->after('customer_last_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bcm_order', function (Blueprint $table) {
            $table->dropColumn('order_date');
            $table->dropColumn('customer_date_of_birth');
        });
    }
}
