<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopProducts extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_products', function($table)
        {
            $table->integer('unit_id');
            $table->dropColumn('unit');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_products', function($table)
        {
            $table->dropColumn('unit_id');
            $table->string('unit', 255);
        });
    }
}
