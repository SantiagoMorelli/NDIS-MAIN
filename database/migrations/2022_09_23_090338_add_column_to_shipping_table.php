<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToShippingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping', function (Blueprint $table) {

            if( ! Schema::hasColumn('shipping','product_sku')){
                Schema::table('shipping', function (Blueprint $table) {
                    $table->string('product_sku', 30)->after('dispatch_time')->nullable();
               });
            }
            if( ! Schema::hasColumn('shipping','supplier_id')){
                Schema::table('shipping', function (Blueprint $table) {
                    $table->text('supplier_id')->after('product_sku')->nullable();
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
                    $table->dropColumn(['product_sku']);
                    $table->dropColumn(['supplier_id']);
            });
        }
    }
}
