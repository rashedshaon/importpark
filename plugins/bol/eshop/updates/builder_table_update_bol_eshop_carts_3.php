<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopCarts3 extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_carts', function($table)
        {
            $table->integer('shipping_method_id')->nullable()->after('user_id');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_carts', function($table)
        {
            $table->dropColumn('shipping_method_id');
        });
    }
}
