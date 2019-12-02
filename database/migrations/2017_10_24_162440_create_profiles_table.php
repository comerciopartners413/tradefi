<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone', 11)->unique();
            $table->date('dob');
            $table->char('gender', 2)->nullable();
            $table->string('address', 255)->nullable();

            $table->timestamps();

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('nationality_id')->nullable();
            $table->unsignedInteger('lga_id')->nullable();
            $table->unsignedInteger('state_id')->nullable();

            $table->foreign('user_id')->references('id')
                ->on('users')->onUpdate('cascade');

            $table->foreign('nationality_id')->references('id')
                ->on('nationalities')->onUpdate('cascade');

            $table->foreign('lga_id')->references('id')
                ->on('lgas')->onUpdate('cascade');

            $table->foreign('state_id')->references('id')
                ->on('states')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
