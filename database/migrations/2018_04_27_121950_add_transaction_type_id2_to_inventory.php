<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionTypeId2ToInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblInventory', function (Blueprint $table) {
            $table->integer('TransactionTypeID2')
                ->after('TransactionTypeID')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblInventory', function (Blueprint $table) {
            $table->dropColumn(['TransactionTypeID2']);
        });
    }
}
