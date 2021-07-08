<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopProductCategories extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_product_categories', function($table)
        {
            $table->dropColumn('id');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_product_categories', function($table)
        {
            $table->increments('id')->unsigned();
        });
    }
}
