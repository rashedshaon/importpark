<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUsers2 extends Migration
{
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->integer('created_by')->nullable()->after('last_login');
            $table->integer('updated_by')->nullable()->after('last_login');
        });
    }
    
    public function down()
    {
        Schema::table('users', function($table)
        {
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
}
