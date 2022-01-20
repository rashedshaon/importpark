<?php namespace Bol\Eshop;

use System\Classes\PluginBase;

use Backend;
use App, Event;
use Controller;
use Bol\Eshop\Classes\TagProcessor;
use Bol\Eshop\Models\Product;
use Bol\Eshop\Models\Category;
use Bol\Eshop\Models\Order;

class Plugin extends PluginBase
{

    public function registerComponents()
    {
        return [
            'Bol\Eshop\Components\Product'           => 'shopProduct',
            'Bol\Eshop\Components\Products'          => 'shopProducts',
            'Bol\Eshop\Components\Categories'        => 'shopCategories',
            'Bol\Eshop\Components\ShoppingCart'      => 'shoppingCart',
            'Bol\Eshop\Components\ShopWishList'      => 'shopWishList',
            'Bol\Eshop\Components\ShopOrders'        => 'shopOrders',
            'Bol\Eshop\Components\ShopCheckout'      => 'shopCheckout',
            'Bol\Eshop\Components\ShopUser'          => 'shopUser',
            'Bol\Eshop\Components\ShopProductSearch' => 'shopProductSearch',
        ];
    }

     /**
     * @return array
     */
    public function registerSettings()
    {
        return [
            'eshop-menu-main-settings' => [
                'label'       => 'bol.eshop::lang.settings.eshop',
                'description' => 'bol.eshop::lang.settings.eshop_description',
                'category'    => 'bol.eshop::lang.settings.tab_eshop',
                'icon'        => 'oc-icon-book',
                'class'       => 'Bol\Eshop\Models\Settings',
                'order'       => 100,
                'permissions' => ['bol.eshop.manage_basic_settings'],
            ],
            'eshop-menu-currencies'      => [
                'label'       => 'bol.eshop::lang.settings.currencies',
                'description' => 'bol.eshop::lang.settings.currency_description',
                'category'    => 'bol.eshop::lang.settings.tab_eshop',
                'icon'        => 'oc-icon-usd',
                'url'         => Backend::url('bol/eshop/currencies'),
                'order'       => 1800,
                'permissions' => ['bol.eshop.manage_currencies'],
            ],
            'eshop-menu-units'      => [
                'label'       => 'bol.eshop::lang.settings.units',
                'description' => 'bol.eshop::lang.settings.units_description',
                'category'    => 'bol.eshop::lang.settings.tab_eshop',
                'icon'        => 'icon-balance-scale',
                'url'         => Backend::url('bol/eshop/units'),
                'order'       => 1801,
                'permissions' => ['bol.eshop.manage_units'],
            ],
            'eshop-menu-order-statuses' => [
                'label'       => 'bol.eshop::lang.settings.order_status',
                'description' => 'bol.eshop::lang.settings.order_statuses_description',
                'category'    => 'bol.eshop::lang.settings.tab_eshop',
                'icon'        => 'icon-random',
                'url'         => Backend::url('bol/eshop/orderstatuses'),
                'order'       => 1802,
                'permissions' => ['bol.eshop.manage_order_status'],
            ],
            'eshop-menu-payment-methods' => [
                'label'       => 'bol.eshop::lang.settings.payment_methods',
                'description' => 'bol.eshop::lang.settings.payment_methods_description',
                'category'    => 'bol.eshop::lang.settings.tab_eshop',
                'icon'        => 'icon-credit-card',
                'url'         => Backend::url('bol/eshop/paymentmethods'),
                'order'       => 1803,
                'permissions' => ['bol.eshop.manage_payment_methods'],
            ],
            'eshop-menu-shipping-methods' => [
                'label'       => 'bol.eshop::lang.settings.shipping_methods',
                'description' => 'bol.eshop::lang.settings.shipping_methods_description',
                'category'    => 'bol.eshop::lang.settings.tab_eshop',
                'icon'        => 'icon-truck',
                'url'         => Backend::url('bol/eshop/shippingmethods'),
                'order'       => 1804,
                'permissions' => ['bol.eshop.manage_shipping_methods'],
            ],
        ];
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
        if (App::runningInBackend())
        {
            // Extend the navigation
            Event::listen('backend.menu.extendItems', function($manager) {
            
            $manager->addSideMenuItems('Bol.Eshop', 'main-menu-item', [
                    'side-menu-item4' => [
                        'counter' => Order::submissionCount(),
                    ],
                ]);
            });
        }
        
        /*
         * Register menu items for the RainLab.Pages plugin
         */
        Event::listen('pages.menuitem.listTypes', function() {
            return [
                'shop-category'          => 'bol.eshop::lang.menuitem.shop_category',
                'all-shop-categories'    => 'bol.eshop::lang.menuitem.all_shop_categories',
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
