<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBolEshopOrderItems extends Migration
{
    public function up()
    {
        Schema::create('bol_eshop_order_items', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('order_id');
            $table->integer('product_id');
            $table->string('title');
            $table->string('size');
            $table->decimal('price', 10, 0);
            $table->decimal('actual_price', 10, 0);
            $table->string('unit');
            $table->integer('quantity');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bol_eshop_order_items');
    }
}
