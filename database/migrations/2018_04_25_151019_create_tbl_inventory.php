<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblInventory', function (Blueprint $table) {
            $table->increments('InventoryRef');
            $table->integer('SecurityID');
            $table->integer('TransactionTypeID');
            $table->integer('Quantity');

            // workflow
            $table->integer('ModuleID')->default(4)->nullable();
            $table->integer('ApproverID')->nullable();
            $table->boolean('NotifyFlag')->default(0);
            $table->boolean('ApprovedFlag')->default(0);
            $table->integer('ApproverID1')->nullable();
            $table->integer('ApproverID2')->nullable();
            $table->integer('ApproverID3')->nullable();
            $table->integer('ApproverID4')->nullable();
            $table->integer('ApproverID5')->nullable();
            $table->integer('ApproverID6')->nullable();
            $table->integer('ApproverID7')->nullable();
            $table->integer('ApproverID8')->nullable();
            $table->integer('ApproverID9')->nullable();
            $table->integer('ApproverID10')->nullable();
            $table->datetime('ApprovalDate')->nullable();
            $table->string('ApproverComment')->nullable();
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
        Schema::dropIfExists('tblInventory');
    }
}
