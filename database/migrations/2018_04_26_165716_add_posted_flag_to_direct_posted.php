<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPostedFlagToDirectPosted extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('direct_deposits', function (Blueprint $table) {
            $table->boolean('PostedFlag')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('direct_deposits', function (Blueprint $table) {
            $table->dropColumn(['PostedFlag']);
        });
    }
}
