<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBolEshopCustomerTypes extends Migration
{
    public function up()
    {
        Schema::create('bol_eshop_customer_types', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('code');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bol_eshop_customer_types');
    }
}
