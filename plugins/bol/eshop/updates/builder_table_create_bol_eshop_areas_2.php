<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBolEshopAreas2 extends Migration
{
    public function up()
    {
        Schema::create('bol_eshop_areas', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('city_id');
            $table->string('name');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bol_eshop_areas');
    }
}
