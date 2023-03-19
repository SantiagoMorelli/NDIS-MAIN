<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditShippingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping', function (Blueprint $table) {

            if( ! Schema::hasColumn('shipping','item_name')){
                Schema::table('shipping', function (Blueprint $table) {
                    $table->text('item_name')->after('dispatch_time')->nullable();
               });
            }
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('shipping')) {
            Schema::table('shipping', function (Blueprint $table) {
                    $table->dropColumn(['item_name']);
            });
        }
    }
}
