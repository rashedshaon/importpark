<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopOrders6 extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_orders', function($table)
        {
            $table->integer('coupon_id')->nullable()->after('status_id');
            $table->integer('shipping_method_id')->after('status_id');
            $table->integer('payment_method_id')->after('status_id');
            $table->dropColumn('coupon_name');
            $table->dropColumn('coupon_discount');
            $table->dropColumn('payment_method');
            $table->dropColumn('delivery_method');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_orders', function($table)
        {
            $table->dropColumn('shipping_method_id');
            $table->dropColumn('payment_method_id');
            $table->dropColumn('coupon_id');
            $table->string('coupon_name', 255)->nullable();
            $table->decimal('coupon_discount', 10, 0)->nullable();
            $table->string('payment_method', 255);
            $table->string('delivery_method', 255);
        });
    }
}
