<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopAreas extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_areas', function($table)
        {
            $table->string('name_bn');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_areas', function($table)
        {
            $table->dropColumn('name_bn');
        });
    }
}
