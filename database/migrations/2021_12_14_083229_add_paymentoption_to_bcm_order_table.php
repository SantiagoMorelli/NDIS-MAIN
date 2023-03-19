<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentoptionToBcmOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bcm_order', function (Blueprint $table) {
            $table->text('payment_option')->default('card')->after('invoice_email_address');
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
            $table->dropColumn('payment_option');
        });
    }
}