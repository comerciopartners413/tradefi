<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMakerCheckerColumnsToSecuritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblSecurity', function (Blueprint $table) {
            $table->integer('ModuleID')->default('2')->nullable();
            $table->integer('ApproverID')->nullable();
            $table->boolean('ApprovedFlag')->nullable();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblSecurity', function (Blueprint $table) {
            //
        });
    }
}
