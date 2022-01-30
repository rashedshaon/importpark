<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopCarts extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_carts', function($table)
        {
            $table->integer('coupon_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_carts', function($table)
        {
            //$table->integer('coupon_id')->nullable(false)->change();
        });
    }
}
