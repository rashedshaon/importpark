<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopOrders3 extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_orders', function($table)
        {
            $table->string('payment_method', 255);
            $table->string('delivery_method', 255);
            $table->dropColumn('payment_mothod');
            $table->dropColumn('delivery_mothod');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_orders', function($table)
        {
            $table->dropColumn('payment_method');
            $table->dropColumn('delivery_method');
            $table->string('payment_mothod', 255);
            $table->string('delivery_mothod', 255);
        });
    }
}
