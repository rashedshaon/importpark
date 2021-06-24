<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopCategories extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_categories', function($table)
        {
            $table->integer('parent_id')->unsigned()->index()->nullable()->after('is_featured');
                $table->integer('nest_left')->nullable()->after('is_featured');
                $table->integer('nest_right')->nullable()->after('is_featured');
                $table->integer('nest_depth')->nullable()->after('is_featured');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_categories', function($table)
        {
            $table->dropColumn('parent_id');
            $table->dropColumn('nest_left');
            $table->dropColumn('nest_right');
            $table->dropColumn('nest_depth');
        });
    }
}
