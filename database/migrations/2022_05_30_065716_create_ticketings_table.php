<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('ticketing')) {
            Schema::create('ticketing', function (Blueprint $table) {
                $table->id();
                $table->string('subject')->nullable();
                $table->string('status')->nullable();
                $table->date('due_date')->nullable();
                $table->text('notes')->nullable();
                $table->string('order_number')->nullable();
                $table->timestamps();
                $table->string('type')->nullable();
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
        if (Schema::hasTable('ticketing')) {
            
            Schema::dropIfExists('ticketing');
        }
    }
}
