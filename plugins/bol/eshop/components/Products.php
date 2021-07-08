<?php namespace Bol\Eshop\Components;

use Lang;
use Redirect;
use BackendAuth;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use October\Rain\Database\Model;
use October\Rain\Database\Collection;
use Bol\Eshop\Models\Product as EshopProduct;
use Bol\Eshop\Models\Category as EshopCategory;
use Bol\Eshop\Models\Settings as EshopSettings;

class Products extends ComponentBase
{
    /**
     * A collection of products to display
     *
     * @var Collection
     */
    public $products;

    /**
     * Parameter to use for the page number
     *
     * @var string
     */
    public $pageParam;

    /**
     * If the product list should be filtered by a category, the model to use
     *
     * @var Model
     */
    public $category;

    /**
     * Message to display when there are no messages
     *
     * @var string
     */
    public $noProductsMessage;

    /**
     * Reference to the page name for linking to products
     *
     * @var string
     */
    public $productPage;

    /**
     * Reference to the page name for linking to categories
     *
     * @var string
     */
    public $categoryPage;

    /**
     * If the product list should be ordered by another attribute
     *
     * @var string
     */
    public $sortOrder;

    public function componentDetails()
    {
        return [
            'name'        => 'bol.eshop::lang.settings.products_title',
            'description' => 'bol.eshop::lang.settings.products_description'
        ];
    }

    public function defineProperties()
    {
        return [
            'pageNumber' => [
                'title'       => 'bol.eshop::lang.settings.products_pagination',
                'description' => 'bol.eshop::lang.settings.products_pagination_description',
                'type'        => 'string',
                'default'     => '{{ :page }}',
            ],
            'categoryFilter' => [
                'title'       => 'bol.eshop::lang.settings.products_filter',
                'description' => 'bol.eshop::lang.settings.products_filter_description',
                'type'        => 'string',
                'default'     => '',
            ],
            'productsPerPage' => [
                'title'             => 'bol.eshop::lang.settings.products_per_page',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'bol.eshop::lang.settings.products_per_page_validation',
                'default'           => '10',
            ],
            'noProductsMessage' => [
                'title'             => 'bol.eshop::lang.settings.products_no_products',
                'description'       => 'bol.eshop::lang.settings.products_no_products_description',
                'type'              => 'string',
                'default'           => Lang::get('bol.eshop::lang.settings.products_no_products_default'),
                'showExternalParam' => false,
            ],
            'sortOrder' => [
                'title'       => 'bol.eshop::lang.settings.products_order',
                'description' => 'bol.eshop::lang.settings.products_order_description',
                'type'        => 'dropdown',
                'default'     => 'published_at desc',
            ],
            'categoryPage' => [
                'title'       => 'bol.eshop::lang.settings.products_category',
                'description' => 'bol.eshop::lang.settings.products_category_description',
                'type'        => 'dropdown',
                'default'     => 'eshop/category',
                'group'       => 'bol.eshop::lang.settings.group_links',
            ],
            'productPage' => [
                'title'       => 'bol.eshop::lang.settings.products_product',
                'description' => 'bol.eshop::lang.settings.products_product_description',
                'type'        => 'dropdown',
                'default'     => 'eshop/product',
                'group'       => 'bol.eshop::lang.settings.group_links',
            ],
            'exceptProduct' => [
                'title'             => 'bol.eshop::lang.settings.products_except_product',
                'description'       => 'bol.eshop::lang.settings.products_except_product_description',
                'type'              => 'string',
                'validationPattern' => '^[a-z0-9\-_,\s]+$',
                'validationMessage' => 'bol.eshop::lang.settings.products_except_product_validation',
                'default'           => '',
                'group'             => 'bol.eshop::lang.settings.group_exceptions',
            ],
            'exceptCategories' => [
                'title'             => 'bol.eshop::lang.settings.products_except_categories',
                'description'       => 'bol.eshop::lang.settings.products_except_categories_description',
                'type'              => 'string',
                'validationPattern' => '^[a-z0-9\-_,\s]+$',
                'validationMessage' => 'bol.eshop::lang.settings.products_except_categories_validation',
                'default'           => '',
                'group'             => 'bol.eshop::lang.settings.group_exceptions',
            ],
        ];
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getProductPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getSortOrderOptions()
    {
        $options = EshopProduct::$allowedSortingOptions;

        foreach ($options as $key => $value) {
            $options[$key] = Lang::get($value);
        }

        return $options;
    }

    public function onRun()
    {
        $this->prepareVars();

        $this->category = $this->page['category'] = $this->loadCategory();
        $this->products = $this->page['products'] = $this->listProducts();

        /*
         * If the page number is not valid, redirect
         */
        if ($pageNumberParam = $this->paramName('pageNumber')) {
            $currentPage = $this->property('pageNumber');

            if ($currentPage > ($lastPage = $this->products->lastPage()) && $currentPage > 1) {
                return Redirect::to($this->currentPageUrl([$pageNumberParam => $lastPage]));
            }
        }
    }

    protected function prepareVars()
    {
        $this->pageParam = $this->page['pageParam'] = $this->paramName('pageNumber');
        $this->noProductsMessage = $this->page['noProductsMessage'] = $this->property('noProductsMessage');

        /*
         * Page links
         */
        $this->productPage = $this->page['productPage'] = $this->property('productPage');
        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
    }

    protected function listProducts()
    {
        $category = $this->category ? $this->category->id : null;
        $categorySlug = $this->category ? $this->category->slug : null;

        /*
         * List all the products, eager load their categories
         */
        $isPublished = !$this->checkEditor();

        $products = EshopProduct::with(['categories', 'photos'])->listFrontEnd([
            'page'             => $this->property('pageNumber'),
            'sort'             => $this->property('sortOrder'),
            'perPage'          => $this->property('productsPerPage'),
            'search'           => trim(input('search')),
            'category'         => $category,
            'published'        => $isPublished,
            'exceptProduct'       => is_array($this->property('exceptProduct'))
                ? $this->property('exceptProduct')
                : preg_split('/,\s*/', $this->property('exceptProduct'), -1, PREG_SPLIT_NO_EMPTY),
            'exceptCategories' => is_array($this->property('exceptCategories'))
                ? $this->property('exceptCategories')
                : preg_split('/,\s*/', $this->property('exceptCategories'), -1, PREG_SPLIT_NO_EMPTY),
        ]);

        /*
         * Add a "url" helper attribute for linking to each product and category
         */
        $products->each(function($product) use ($categorySlug) {
            $product->setUrl($this->productPage, $this->controller, ['category' => $categorySlug]);

            $product->categories->each(function($category) {
                $category->setUrl($this->categoryPage, $this->controller);
            });
        });

        return $products;
    }

    protected function loadCategory()
    {
        if (!$slug = $this->property('categoryFilter')) {
            return null;
        }

        $category = new EshopCategory;

        $category = $category->isClassExtendedWith('RainLab.Translate.Behaviors.TranslatableModel')
            ? $category->transWhere('slug', $slug)
            : $category->where('slug', $slug);

        $category = $category->first();

        return $category ?: null;
    }

    protected function checkEditor()
    {
        $backendUser = BackendAuth::getUser();

        return $backendUser && $backendUser->hasAccess('bol.eshop.manage_products') && EshopSettings::get('show_all_products', true);
    }
}
