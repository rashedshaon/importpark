<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopCurrencies extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_currencies', function($table)
        {
            $table->integer('sort_order')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_currencies', function($table)
        {
            //$table->integer('sort_order')->nullable(false)->change();
        });
    }
}
