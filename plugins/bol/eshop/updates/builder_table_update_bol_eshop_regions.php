<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopRegions extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_regions', function($table)
        {
            $table->string('name_bn');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_regions', function($table)
        {
            $table->dropColumn('name_bn');
        });
    }
}
