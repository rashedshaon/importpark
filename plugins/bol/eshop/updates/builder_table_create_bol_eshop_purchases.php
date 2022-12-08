<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBolEshopPurchases extends Migration
{
    public function up()
    {
        Schema::create('bol_eshop_purchases', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('supplier_id');
            $table->string('paid_amount')->nullable();
            $table->integer('tracking_id')->nullable();
            $table->string('gross_weight')->nullable()->nullable();
            $table->string('dimension')->nullable();
            $table->integer('cartoon_quantity')->nullable();
            $table->boolean('has_battery')->default(0);
            $table->integer('status_id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bol_eshop_purchases');
    }
}
