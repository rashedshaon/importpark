<?php namespace Bol\Eshop;

use System\Classes\PluginBase;

use Backend;
use Controller;
use Bol\Eshop\Classes\TagProcessor;
use Bol\Eshop\Models\Product;
use Bol\Eshop\Models\Category;
use Event;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Bol\Eshop\Components\Product'       => 'shopProduct',
            'Bol\Eshop\Components\Products'      => 'shopProducts',
            'Bol\Eshop\Components\Categories'    => 'shopCategories',
        ];
    }

    public function registerSettings()
    {
    }

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register()
    {
        /*
         * Register the image tag processing callback
         */
        TagProcessor::instance()->registerCallback(function($input, $preview) {
            if (!$preview) {
                return $input;
            }

            return preg_replace('|\<img src="image" alt="([0-9]+)"([^>]*)\/>|m',
                '<span class="image-placeholder" data-index="$1">
                    <span class="upload-dropzone">
                        <span class="label">Click or drop an image...</span>
                        <span class="indicator"></span>
                    </span>
                </span>',
            $input);
        });
    }

    public function boot()
    {
        /*
         * Register menu items for the RainLab.Pages plugin
         */
        Event::listen('pages.menuitem.listTypes', function() {
            return [
                'shop-category'       => 'bol.eshop::lang.menuitem.shop_category',
                'all-shop-categories' => 'bol.eshop::lang.menuitem.all_shop_categories',
                'shop-product'           => 'bol.eshop::lang.menuitem.shop_product',
                'all-shop-products'      => 'bol.eshop::lang.menuitem.all_shop_products',
                'category-shop-products' => 'bol.eshop::lang.menuitem.category_shop_products',
            ];
        });

        Event::listen('pages.menuitem.getTypeInfo', function($type) {
            if ($type == 'shop-category' || $type == 'all-shop-categories') {
                return Category::getMenuTypeInfo($type);
            }
            elseif ($type == 'shop-product' || $type == 'all-shop-products' || $type == 'category-shop-products') {
                return Product::getMenuTypeInfo($type);
            }
        });

        Event::listen('pages.menuitem.resolveItem', function($type, $item, $url, $theme) {
            if ($type == 'shop-category' || $type == 'all-shop-categories') {
                return Category::resolveMenuItem($item, $url, $theme);
            }
            elseif ($type == 'shop-product' || $type == 'all-shop-products' || $type == 'category-shop-products') {
                return Product::resolveMenuItem($item, $url, $theme);
            }
        });
    }
}
