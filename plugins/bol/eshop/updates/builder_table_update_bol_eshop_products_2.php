<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopProducts2 extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_products', function($table)
        {
            $table->integer('unit_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_products', function($table)
        {
            $table->integer('unit_id')->nullable(false)->change();
        });
    }
}
