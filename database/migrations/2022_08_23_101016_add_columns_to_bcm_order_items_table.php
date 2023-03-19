<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBcmOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('bcm_order_items') ) {
            
            if( ! Schema::hasColumn('bcm_order_items','supplier_order_date')){
                Schema::table('bcm_order_items', function (Blueprint $table) {
                    $table->dateTime('supplier_order_date')->after('item_price')->nullable();
               });
            }
            if( ! Schema::hasColumn('bcm_order_items','order_place_to_supplier_userid')){
                Schema::table('bcm_order_items', function (Blueprint $table) {
                    $table->text('order_place_to_supplier_userid')->after('supplier_order_date')->nullable()->comment("'0' => 'Paid orders', '1' => 'Pending orders'");
               });
            }  
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('bcm_order_items')) {

            Schema::table('bcm_order_items', function (Blueprint $table) {
                $table->dropColumn(['supplier_order_date']);
                $table->dropColumn(['order_place_to_supplier_userid']);
            });
        }
    }
}
