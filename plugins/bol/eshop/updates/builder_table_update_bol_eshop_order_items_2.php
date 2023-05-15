<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopOrderItems2 extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_order_items', function($table)
        {
            $table->integer('created_by')->nullable()->after('quantity');
            $table->integer('updated_by')->nullable()->after('quantity');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_order_items', function($table)
        {
            $table->dropColumn('d');
        });
    }
}
