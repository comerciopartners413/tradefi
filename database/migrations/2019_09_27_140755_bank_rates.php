<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BankRates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('tblTradeData', function(Blueprint $table){
        $table->float('BankYield')->nullable();
      });
      Schema::table('tblPriceUpload', function(Blueprint $table){
        $table->integer('SecurityID')->nullable();
      });
      Schema::table('tblPriceUploadHistory', function(Blueprint $table){
        $table->integer('SecurityID')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('tblTradeData', function(Blueprint $table){
        $table->dropColumn('BankYield');
      });
      Schema::table('tblPriceUpload', function(Blueprint $table){
        $table->dropColumn('SecurityID');
      });
      Schema::table('tblPriceUploadHistory', function(Blueprint $table){
        $table->dropColumn('SecurityID');
      });
    }
}
