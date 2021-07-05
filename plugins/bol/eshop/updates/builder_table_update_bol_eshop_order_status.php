<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopOrderStatus extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_order_status', function($table)
        {
            $table->string('code')->after('name');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_order_status', function($table)
        {
            $table->dropColumn('code');
        });
    }
}
