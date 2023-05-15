<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopOrders8 extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_orders', function($table)
        {
            $table->integer('created_by')->nullable()->after('remarks');
            $table->integer('updated_by')->nullable()->after('remarks');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_orders', function($table)
        {
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
}
