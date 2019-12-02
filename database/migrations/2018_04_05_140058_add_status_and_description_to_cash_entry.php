<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusAndDescriptionToCashEntry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblCashEntry', function (Blueprint $table) {
            $table->string('Status')->nullable();
            $table->string('Description')->nullable();
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
            $table->dropColumn(['Status', 'Description']);
        });
    }
}
