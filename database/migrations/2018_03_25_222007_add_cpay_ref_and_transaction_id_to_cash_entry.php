<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCpayRefAndTransactionIdToCashEntry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblCashEntry', function (Blueprint $table) {
            $table->string('cpay_ref', 50)->nullable();
            $table->string('transaction_id', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblCashEntry', function (Blueprint $table) {
            $table->dropColumn(['cpay_ref', 'transaction_id']);
        });
    }
}
