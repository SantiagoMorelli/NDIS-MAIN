<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignmentToBcmOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('bcm_order') && !Schema::hasColumn('bcm_order','assigned_to')) {
            
            Schema::table('bcm_order', function (Blueprint $table) {
                //
                $table->string('assigned_to')->nullable();
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
        if (Schema::hasTable('bcm_order') && Schema::hasColumn('bcm_order','assigned_to')) {
            
            Schema::table('bcm_order', function (Blueprint $table) {
                //
                $table->dropColumn('assigned_to');
            });
        }
    }
}
