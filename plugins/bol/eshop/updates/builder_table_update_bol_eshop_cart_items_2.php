<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopCartItems2 extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_cart_items', function($table)
        {
            $table->integer('cart_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_cart_items', function($table)
        {
            $table->integer('cart_id')->nullable(false)->change();
        });
    }
}
