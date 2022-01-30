<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBolEshopCurrencies extends Migration
{
    public function up()
    {
        Schema::create('bol_eshop_currencies', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('code');
            $table->string('symbol');
            $table->boolean('is_default');
            $table->boolean('is_active');
            $table->integer('sort_order')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bol_eshop_currencies');
    }
}
