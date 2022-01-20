<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopPaymentMethods2 extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_payment_methods', function($table)
        {
            $table->text('description')->nullable()->after('code');
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_payment_methods', function($table)
        {
            $table->dropColumn('description');
        });
    }
}
