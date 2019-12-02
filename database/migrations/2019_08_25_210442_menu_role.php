<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MenuRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menus', function(Blueprint $table){
          $table->integer('order')->default('0');
          $table->string('icon')->nullable();
          $table->boolean('is_admin')->default(false);
        });
        Schema::create('menu_role', function(Blueprint $table){
          $table->integer('menu_id')->unsigned();
          $table->integer('role_id')->unsigned();

          $table->foreign('menu_id')->references('id')->on('menus')
              ->onUpdate('cascade')->onDelete('cascade');
          $table->foreign('role_id')->references('id')->on('roles')
              ->onUpdate('cascade')->onDelete('cascade');

          $table->primary(['menu_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('menus', function(Blueprint $table){
        $table->dropColumn('order');
        $table->dropColumn('icon');
      });
      Schema::dropIfExists('menu_role');
    }
}
