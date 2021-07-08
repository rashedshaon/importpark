<?php namespace Bol\Eshop\Components;

use Db;
use Carbon\Carbon;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Bol\Eshop\Models\Category as EshopCategory;

class Categories extends ComponentBase
{
    /**
     * @var Collection A collection of categories to display
     */
    public $categories;

    /**
     * @var string Reference to the page name for linking to categories.
     */
    public $categoryPage;

    /**
     * @var string Reference to the current category slug.
     */
    public $currentCategorySlug;

    public function componentDetails()
    {
        return [
            'name'        => 'bol.eshop::lang.settings.category_title',
            'description' => 'bol.eshop::lang.settings.category_description'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'bol.eshop::lang.settings.category_slug',
                'description' => 'bol.eshop::lang.settings.category_slug_description',
                'default'     => '{{ :slug }}',
                'type'        => 'string',
            ],
            'displayEmpty' => [
                'title'       => 'bol.eshop::lang.settings.category_display_empty',
                'description' => 'bol.eshop::lang.settings.category_display_empty_description',
                'type'        => 'checkbox',
                'default'     => 0,
            ],
            'categoryPage' => [
                'title'       => 'bol.eshop::lang.settings.category_page',
                'description' => 'bol.eshop::lang.settings.category_page_description',
                'type'        => 'dropdown',
                'default'     => 'product/category',
                'group'       => 'bol.eshop::lang.settings.group_links',
            ],
        ];
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->currentCategorySlug = $this->page['currentCategorySlug'] = $this->property('slug');
        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
        $this->categories = $this->page['categories'] = $this->loadCategories();
    }

    /**
     * Load all categories or, depending on the <displayEmpty> option, only those that have blog products
     * @return mixed
     */
    protected function loadCategories()
    {
        $categories = EshopCategory::with('products_count')->getNested();
        if (!$this->property('displayEmpty')) {
            $iterator = function ($categories) use (&$iterator) {
                return $categories->reject(function ($category) use (&$iterator) {
                    if ($category->getNestedProductCount() == 0) {
                        return true;
                    }
                    if ($category->children) {
                        $category->children = $iterator($category->children);
                    }
                    return false;
                });
            };
            $categories = $iterator($categories);
        }

        /*
         * Add a "url" helper attribute for linking to each category
         */
        return $this->linkCategories($categories);
    }

    /**
     * Sets the URL on each category according to the defined category page
     * @return void
     */
    protected function linkCategories($categories)
    {
        return $categories->each(function ($category) {
            $category->setUrl($this->categoryPage, $this->controller);

            if ($category->children) {
                $this->linkCategories($category->children);
            }
        });
    }
}
