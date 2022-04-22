<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBolEshopCities extends Migration
{
    public function up()
    {
        Schema::create('bol_eshop_cities', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('region_id');
            $table->string('name');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bol_eshop_cities');
    }
}
