<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopShippingMethods extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_shipping_methods', function($table)
        {
            $table->integer('sort_order')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_shipping_methods', function($table)
        {
            $table->integer('sort_order')->nullable(false)->change();
        });
    }
}
