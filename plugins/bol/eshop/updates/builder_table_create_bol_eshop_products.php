<?php namespace Bol\Eshop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBolEshopProducts extends Migration
{
    public function up()
    {
        Schema::create('bol_eshop_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->string('slug');
            $table->text('short_description');
            $table->text('description');
            $table->string('video_url')->nullable();
            $table->integer('page_view')->default(0);
            $table->integer('view')->default(0);
            $table->text('sizes')->nullable();
            $table->text('colors')->nullable();
            $table->string('weight')->nullable();
            $table->string('unit');
            $table->string('type');
            $table->string('download_type')->nullable();
            $table->string('download_link')->nullable();
            $table->integer('brand_id')->nullable();
            $table->decimal('price', 15, 2);
            $table->decimal('discount', 15, 2)->nullable();
            $table->string('discount_type')->nullable();
            $table->dateTime('discount_start')->nullable();
            $table->dateTime('discount_end')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->boolean('is_featured')->default(0);
            $table->boolean('is_published')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bol_eshop_products');
    }
}
