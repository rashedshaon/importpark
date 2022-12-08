<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopOrders7 extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_orders', function($table)
        {
            $table->boolean('has_remainder')->default(0)->after('coupon_id');
            $table->date('remainder_date')->nullable()->after('coupon_id');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_orders', function($table)
        {
            $table->dropColumn('has_remainder');
            $table->dropColumn('remainder_date');
        });
    }
}
