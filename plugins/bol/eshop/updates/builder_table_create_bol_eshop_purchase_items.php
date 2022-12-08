<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBolEshopPurchaseItems extends Migration
{
    public function up()
    {
        Schema::create('bol_eshop_purchase_items', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('purchase_id');
            $table->integer('product_id');
            $table->string('price');
            $table->integer('quantity');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bol_eshop_purchase_items');
    }
}
