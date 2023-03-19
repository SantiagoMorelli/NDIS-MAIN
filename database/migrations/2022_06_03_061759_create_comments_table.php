<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    
    {
        if (!Schema::hasTable('comment')) {
            Schema::create('comment', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('order_number');
                $table->timestamps();
                $table->text('comment');
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
        if (Schema::hasTable('comment')) {
            
            Schema::dropIfExists('comment');
        }
    }
}
