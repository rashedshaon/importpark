<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopOrders extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_orders', function($table)
        {
            $table->integer('status')->nullable(false)->unsigned(false)->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_orders', function($table)
        {
            $table->boolean('status')->nullable(false)->unsigned(false)->default(0)->change();
        });
    }
}
