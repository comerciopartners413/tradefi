<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PriceUploadHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('tblPriceUploadHistory', function(Blueprint $table) {
        $table->increments('PriceUploadRef');
        $table->date('MaturityDate');
        $table->integer('TenorToMaturity');
        $table->float('AmountAvailable');
        $table->float('BuyRate');
        $table->float('SellRate');
        $table->integer('InitiatorID')->nullable();
        // $table->boolean('ConfirmFlag')->default(false);
        $table->integer('ConfirmerID')->nullable();
        $table->datetime('ConfirmDate')->nullable();
        // $table->boolean('ApprovedFlag')->default(false);
        $table->integer('ApproverID')->nullable();
        $table->datetime('ApprovedDate')->nullable();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('tblPriceUploadHistory');
    }
}
