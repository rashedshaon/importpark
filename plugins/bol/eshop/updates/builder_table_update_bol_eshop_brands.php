<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopBrands extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_brands', function($table)
        {
            $table->string('slug')->unique()->after('name');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_brands', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
