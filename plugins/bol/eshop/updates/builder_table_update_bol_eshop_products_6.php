<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopProducts6 extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_products', function($table)
        {
            $table->integer('page_view')->nullable()->change();
            $table->integer('view')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_products', function($table)
        {
            $table->integer('page_view')->nullable(false)->change();
            $table->integer('view')->nullable(false)->change();
        });
    }
}
