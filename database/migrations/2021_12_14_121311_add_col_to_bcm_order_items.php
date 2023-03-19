<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToBcmOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bcm_order_items', function (Blueprint $table) {
            $table->string('product_category', 100)->after('item_price');
            $table->string('product_category_item', 100)->after('product_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bcm_order_items', function (Blueprint $table) {
            $table->dropColumn('product_catgory');
            $table->dropColumn('product_category_item');
        });
    }
}