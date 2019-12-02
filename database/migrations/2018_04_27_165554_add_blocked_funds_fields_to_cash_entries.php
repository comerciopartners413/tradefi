<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBlockedFundsFieldsToCashEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblCashEntry', function (Blueprint $table) {
            $table->boolean('BlockedFlag')->default(0);
            $table->integer('BlockedAmount')->nullable();
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
            $table->dropColumn(['BlockedFlag', 'BlockedAmount']);
        });
    }
}
