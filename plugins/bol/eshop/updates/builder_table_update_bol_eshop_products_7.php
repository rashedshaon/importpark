<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBolEshopProducts7 extends Migration
{
    public function up()
    {
        Schema::table('bol_eshop_products', function($table)
        {
            $table->string('slug', 255)->nullable()->change();
            $table->text('short_description')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->string('type', 255)->nullable()->change();
            $table->decimal('price', 15, 2)->nullable()->change();
            $table->integer('created_by')->nullable()->change();
            $table->integer('updated_by')->nullable()->change();
            $table->boolean('is_featured')->nullable()->change();
            $table->boolean('is_published')->nullable()->change();
            $table->integer('unit_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('bol_eshop_products', function($table)
        {
            $table->string('slug', 255)->nullable(false)->change();
            $table->text('short_description')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
            $table->string('type', 255)->nullable(false)->change();
            $table->decimal('price', 15, 2)->nullable(false)->change();
            $table->integer('created_by')->nullable(false)->change();
            $table->integer('updated_by')->nullable(false)->change();
            $table->boolean('is_featured')->nullable(false)->change();
            $table->boolean('is_published')->nullable(false)->change();
            $table->integer('unit_id')->nullable(false)->change();
        });
    }
}
