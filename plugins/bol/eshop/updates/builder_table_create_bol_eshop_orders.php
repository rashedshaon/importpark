<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBolEshopOrders extends Migration
{
    public function up()
    {
        Schema::create('bol_eshop_orders', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('customer_name');
            $table->text('delivery_address')->nullable();
            $table->text('billing_address')->nullable();
            $table->string('payment_mothod');
            $table->string('delivery_mothod');
            $table->decimal('tax_percent', 10, 0)->nullable();
            $table->decimal('other_deduction', 10, 0)->nullable();
            $table->string('coupon_name')->nullable();
            $table->decimal('coupon_discount', 10, 0)->nullable();
            $table->boolean('payment_status')->default(0);
            $table->boolean('status')->default(0);
            $table->text('remarks')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bol_eshop_orders');
    }
}
