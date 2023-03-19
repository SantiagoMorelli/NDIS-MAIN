<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailLogsTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('email_logs')) {
            Schema::create('email_logs', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('order_number')->nullable();
                $table->string('subject')->nullable();
                $table->string('to')->nullable();
                $table->string('from')->nullable();
                $table->string('cc')->nullable();
                $table->string('bcc')->nullable();
                $table->string('email_sent_date')->nullable();
                $table->timestamps();
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
        if (!Schema::hasTable('email_logs')) {
            Schema::dropIfExists('email_logs');
        }
    }
}
