<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToSupplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('supplier') && ! Schema::hasColumn('record_number','invoice_number','phone_number','contact_person','note')) {
            
            Schema::table('supplier', function (Blueprint $table) {
                //
                $table->id('record_number')->comment('primary key');
                $table->string('invoice_number')->nullable();
                $table->string('phone_number')->nullable();
                $table->string('contact_person')->nullable();
                $table->text('note')->nullable();
                
    
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
        if (Schema::hasTable('supplier')  && Schema::hasColumn('record_number','invoice_number','phone_number','contact_person','note')) {
            
            Schema::table('supplier', function (Blueprint $table) {
                //
                $table->dropColumn(['record_number','invoice_number','phone_number','contact_person','note']);
            });
        }
    }
}
