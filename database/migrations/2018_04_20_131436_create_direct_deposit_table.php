<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectDepositTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_deposits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('CustomerID')->nullable();
            $table->integer('ApproverID')->nullable();
            $table->boolean('ApprovalStatus')->nullable();
            $table->string('pop');
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
        Schema::dropIfExists('direct_deposits');
    }
}
