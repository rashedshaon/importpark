<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBolEshopStocks extends Migration
{
    public function up()
    {
        Schema::create('bol_eshop_stocks', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('product_id');
            $table->integer('quantity');
            $table->string('purchase_price')->nullable();
            $table->date('purchase_date');
            $table->integer('vendor_id');
            $table->integer('created_by');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bol_eshop_stocks');
    }
}
