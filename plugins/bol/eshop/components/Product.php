<?php namespace Bol\Eshop\Components;

use Event;
use BackendAuth;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Bol\Eshop\Models\Product as EshopProduct;

class Product extends ComponentBase
{
    /**
     * @var Bol\Eshop\Models\Product The product model used for display.
     */
    public $product;

    /**
     * @var string Reference to the page name for linking to categories.
     */
    public $categoryPage;

    public function componentDetails()
    {
        return [
            'name'        => 'bol.eshop::lang.settings.product_title',
            'description' => 'bol.eshop::lang.settings.product_description'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'bol.eshop::lang.settings.product_slug',
                'description' => 'bol.eshop::lang.settings.product_slug_description',
                'default'     => '{{ :slug }}',
                'type'        => 'string',
            ],
            'categoryPage' => [
                'title'       => 'bol.eshop::lang.settings.product_category',
                'description' => 'bol.eshop::lang.settings.product_category_description',
                'type'        => 'dropdown',
                'default'     => 'product/category',
            ],
        ];
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function init()
    {
        Event::listen('translate.localePicker.translateParams', function ($page, $params, $oldLocale, $newLocale) {
            $newParams = $params;

            if (isset($params['slug'])) {
                $records = EshopProduct::transWhere('slug', $params['slug'], $oldLocale)->first();
                if ($records) {
                    $records->translateContext($newLocale);
                    $newParams['slug'] = $records['slug'];
                }
            }

            return $newParams;
        });
    }

    public function onRun()
    {
        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
        $this->product = $this->page['product'] = $this->loadProduct();
        if (!$this->product) {
            $this->setStatusCode(404);
            return $this->controller->run('404');
        }
    }

    public function onRender()
    {
        if (empty($this->product)) {
            $this->product = $this->page['product'] = $this->loadProduct();
        }
    }

    protected function loadProduct()
    {
        $slug = $this->property('slug');

        $product = new EshopProduct;
        $query = $product->query();

        if ($product->isClassExtendedWith('RainLab.Translate.Behaviors.TranslatableModel')) {
            $query->transWhere('slug', $slug);
        } else {
            $query->where('slug', $slug);
        }

        if (!$this->checkEditor()) {
            $query->isPublished();
        }

        $product = $query->first();

        /*
         * Add a "url" helper attribute for linking to each category
         */
        if ($product && $product->exists && $product->categories->count()) {
            $product->categories->each(function($category) {
                $category->setUrl($this->categoryPage, $this->controller);
            });
        }

        return $product;
    }

    public function previousProduct()
    {
        return $this->getProductSibling(-1);
    }

    public function nextProduct()
    {
        return $this->getProductSibling(1);
    }

    protected function getProductSibling($direction = 1)
    {
        if (!$this->product) {
            return;
        }

        $method = $direction === -1 ? 'previousProduct' : 'nextProduct';

        if (!$product = $this->product->$method()) {
            return;
        }

        $productPage = $this->getPage()->getBaseFileName();

        $product->setUrl($productPage, $this->controller);

        $product->categories->each(function($category) {
            $category->setUrl($this->categoryPage, $this->controller);
        });

        return $product;
    }

    protected function checkEditor()
    {
        $backendUser = BackendAuth::getUser();

        return $backendUser && $backendUser->hasAccess('bol.eshop.manage_products');
    }
}
