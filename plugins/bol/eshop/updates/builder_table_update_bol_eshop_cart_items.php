<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopCartItems extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_cart_items', function($table)
        {
            $table->string('price')->nullable()->after('product_id');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_cart_items', function($table)
        {
            $table->dropColumn('price');
        });
    }
}
