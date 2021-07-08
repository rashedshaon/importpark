<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopCarts2 extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_carts', function($table)
        {
            $table->string('session_id')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_carts', function($table)
        {
            $table->integer('session_id')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
