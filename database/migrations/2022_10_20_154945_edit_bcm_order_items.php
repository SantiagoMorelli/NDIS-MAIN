<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditBcmOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('bcm_order_items') ) {
            
            if( ! Schema::hasColumn('bcm_order_items','item_size')){
                Schema::table('bcm_order_items', function (Blueprint $table) {
                    $table->text('item_size')->after('item_quantity')->nullable();
               });
            }
            if( ! Schema::hasColumn('bcm_order_items','item_colour')){
                Schema::table('bcm_order_items', function (Blueprint $table) {
                    $table->text('item_colour')->after('item_size')->nullable();
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
                $table->dropColumn(['item_size']);
                $table->dropColumn(['item_colour']);
            });
        }
    }
}

