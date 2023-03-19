<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditChangeLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('audit_change_log')) {
            Schema::create('audit_change_log', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('page_id',100)->nullable();
                $table->string('action',100)->nullable();
                $table->bigInteger('created_user_id')->index();
                $table->bigInteger('orders_id')->nullable()->index();
                $table->timestamp('created_at');
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
        Schema::dropIfExists('audit_change_log');
    }
}
