<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PriceUploadBonds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('tblPriceUpload', function(Blueprint $table){
        $table->string('SecurityIdentifier')->nullable();

        $table->date('MaturityDate')->nullable()->change();
        $table->integer('TenorToMaturity')->nullable()->change();
        // $table->float('AmountAvailable')->nullable()->change();
        // $table->float('BuyRate')->nullable()->change();
        // $table->float('SellRate')->nullable()->change();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('tblPriceUpload', function(Blueprint $table){
        $table->dropColumn('SecurityIdentifier');
        $table->date('MaturityDate')->change();
        $table->integer('TenorToMaturity')->change();
      });
    }
}
