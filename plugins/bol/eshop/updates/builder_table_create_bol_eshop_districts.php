<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBolEshopDistricts extends Migration
{
    public function up()
    {
        Schema::create('bol_eshop_districts', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bol_eshop_districts');
    }
}
