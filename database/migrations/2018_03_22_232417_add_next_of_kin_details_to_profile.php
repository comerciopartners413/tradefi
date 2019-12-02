<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNextOfKinDetailsToProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('kin_fullname')->nullable();
            $table->string('kin_relationship')->nullable();
            $table->string('kin_address')->nullable();
            $table->string('kin_phone')->nullable();
            $table->string('trading_experience')->nullable();
            $table->string('income_bracket')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['fullname', 'relationship', 'address', 'phone', 'trading_experience', 'income_bracket']);
        });
    }
}
