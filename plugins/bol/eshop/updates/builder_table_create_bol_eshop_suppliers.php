<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBolEshopSuppliers extends Migration
{
    public function up()
    {
        Schema::create('bol_eshop_suppliers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('alibaba_url')->nullable();
            $table->string('wechat_id')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bol_eshop_suppliers');
    }
}
