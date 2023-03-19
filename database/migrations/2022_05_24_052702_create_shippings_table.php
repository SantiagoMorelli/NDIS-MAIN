<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('shipping')) {
            Schema::create('shipping', function (Blueprint $table) {
                $table->id();
                $table->string('tracking_number')->nullable();
                $table->string('courier_company')->nullable();
                $table->string('expected_time_of_arrival')->nullable();
                $table->string('dispatch_time')->nullable();
                $table->text('notes')->nullable();
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
        if (Schema::hasTable('shipping')) {
            
            Schema::dropIfExists('shipping');
        }
    }
}
