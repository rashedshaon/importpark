<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopShippingMethods2 extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_shipping_methods', function($table)
        {
            $table->text('description')->nullable()->after('price');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_shipping_methods', function($table)
        {
            $table->dropColumn('description');
        });
    }
}
