<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBolEshopVendorProducts extends Migration
{
    public function up()
    {
        Schema::create('bol_eshop_vendor_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('vendor_id');
            $table->integer('product_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bol_eshop_vendor_products');
    }
}
