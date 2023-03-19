<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnToPersonalAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('personal_access_tokens')) {
            if (Schema::hasColumn('personal_access_tokens', 'tokenable_type')) {
                DB::statement("ALTER TABLE `personal_access_tokens` CHANGE `tokenable_type` `tokenable_type` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;");
            }
            if (Schema::hasColumn('personal_access_tokens', 'tokenable_id')) {
                DB::statement("ALTER TABLE `personal_access_tokens` CHANGE `tokenable_id` `tokenable_id` BIGINT(20) UNSIGNED NULL;");
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
        
    }
}
