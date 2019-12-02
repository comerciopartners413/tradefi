<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UbaRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('companies', function(Blueprint $table){
        $table->increments('id');
        $table->string('name');
      });
      DB::table('companies')->insert([
        ['name'=>'tradefi'],
        ['name'=>'uba']
      ]);
      // DB::table('permissions')->insert([
      //   ['name'=>'upload_prices', 'company_id'=>'2'],
      //   ['name'=>'approve_prices', 'company_id'=>'2'],
      //   ['name'=>'view_price_history', 'company_id'=>'2'],
      //   ['name'=>'view_inventory', 'company_id'=>'2'],
      //   ['name'=>'download_settlement_reports', 'company_id'=>'2'],
      //   ['name'=>'download_valuation_reports', 'company_id'=>'2'],
      //   ['name'=>'download_aggregate_instructions', 'company_id'=>'2'],
      //   ['name'=>'upload_settlement_accounts', 'company_id'=>'2'],
      // ]);
      Schema::table('roles', function(Blueprint $table){
        $table->integer('company_id')->default('1');
        $table->integer('inputter_id')->nullable();
      });
      Schema::table('permissions', function(Blueprint $table){
        $table->integer('company_id')->default('1');
        $table->integer('inputter_id')->nullable();
      });
      Schema::table('users', function(Blueprint $table){
        $table->integer('company_id')->default('1');
        $table->integer('inputter_id')->nullable();
      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('companies');
      Schema::table('roles', function(Blueprint $table){
        $table->dropColumn('company_id');
        $table->dropColumn('inputter_id');
      });
      Schema::table('permissions', function(Blueprint $table){
        $table->dropColumn('company_id');
        $table->dropColumn('inputter_id');
      });
      Schema::table('users', function(Blueprint $table){
        $table->dropColumn('company_id');
        $table->dropColumn('inputter_id');
      });
    }
}
