<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopOrders2 extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_orders', function($table)
        {
            $table->integer('user_id')->nullable()->after('id');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_orders', function($table)
        {
            $table->dropColumn('user_id');
        });
    }
}
