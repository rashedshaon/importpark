<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopProducts5 extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_products', function($table)
        {
            $table->string('daraz_price')->nullable()->after('supplier_id');
            $table->string('daraz_percent')->nullable()->after('supplier_id');
            $table->string('shipping_cost')->nullable()->after('supplier_id');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_products', function($table)
        {
            $table->dropColumn('daraz_price');
            $table->dropColumn('daraz_percent');
            $table->dropColumn('shipping_cost');
        });
    }
}
