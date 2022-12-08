<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBolEshopItemsStatuses extends Migration
{
    public function up()
    {
        Schema::create('bol_eshop_items_statuses', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('code');
            $table->string('color');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bol_eshop_items_statuses');
    }
}
