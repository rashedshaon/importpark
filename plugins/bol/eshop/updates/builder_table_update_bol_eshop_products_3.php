<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopProducts3 extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_products', function($table)
        {
            $table->string('short_title')->nullable()->after('title');
            $table->integer('supplier_id')->nullable()->after('discount_end');
            $table->string('label_code')->nullable()->after('discount_end');
            $table->string('seller_sku')->nullable()->after('discount_end');
            $table->string('cost_bdt')->nullable()->after('discount_end');
            $table->string('cost_rmb')->nullable()->after('discount_end');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_products', function($table)
        {
            $table->dropColumn('short_title');
            $table->dropColumn('supplier_id');
            $table->dropColumn('cost_rmb');
            $table->dropColumn('cost_bdt');
            $table->dropColumn('seller_sku');
            $table->dropColumn('label_code');
        });
    }
}
