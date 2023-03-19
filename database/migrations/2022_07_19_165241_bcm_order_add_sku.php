<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//class AddMoreColumnsToBcmOrderItemNew extends Migration
class BcmOrderAddSku extends Migration

{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('bcm_order_items') && ! Schema::hasColumn('bcm_order_items','item_sku')) {
            
            Schema::table('bcm_order_items', function (Blueprint $table) {
                //
                $table->string('item_sku',100)->after('item_name')->nullable();
                
    
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
        if (Schema::hasTable('bcm_order_items')  && Schema::hasColumn('bcm_order_items','item_sku')) {
            
            Schema::table('bcm_order_items', function (Blueprint $table) {
                //
                $table->dropColumn(['item_sku']);
            });
        }
    }
}
