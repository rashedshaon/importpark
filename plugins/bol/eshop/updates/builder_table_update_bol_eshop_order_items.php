<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopOrderItems extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_order_items', function($table)
        {
            $table->string('color')->nullable()->after('title');
            $table->string('size', 255)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_order_items', function($table)
        {
            $table->dropColumn('color');
            $table->string('size', 255)->nullable(false)->change();
        });
    }
}
