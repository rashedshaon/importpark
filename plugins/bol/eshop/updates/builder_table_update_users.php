<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->boolean('has_remainder')->default(0)->after('email');
            $table->date('remainder_date')->nullable()->after('email');
            $table->text('remarks')->nullable()->after('email');
            $table->integer('area_id')->after('email')->nullable();
            $table->integer('city_id')->after('email')->nullable();
            $table->integer('region_id')->after('email')->nullable();
            $table->string('type_id')->after('email');
        });
    }
    
    public function down()
    {
        Schema::table('users', function($table)
        {
            $table->dropColumn('area_id');
            $table->dropColumn('city_id');
            $table->dropColumn('region_id');
            $table->dropColumn('type_id');
            $table->dropColumn('has_remainder');
            $table->dropColumn('remainder_date');
            $table->dropColumn('remarks');
        });
    }
}
