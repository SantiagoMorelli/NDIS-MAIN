<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('orders')) {
            if (!Schema::hasColumn('orders', 'gst_total')) {
                Schema::table('orders', function($table) {
                    $table->decimal('gst_total')->after('order_total')->default(0);
                });
            }
            if (!Schema::hasColumn('orders', 'response')) {
                Schema::table('orders', function($table) {
                    $table->text('response')->after('order_status')->nullable();
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['response']);
        });
    }
}
