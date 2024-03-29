<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBolEshopProductItems extends Migration
{
    public function up()
    {
        Schema::create('bol_eshop_product_items', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('product_id')->nullable();
            $table->string('order_number')->nullable();
            $table->string('serial')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('status_id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bol_eshop_product_items');
    }
}
