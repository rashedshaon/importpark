<?php namespace Bol\Eshop\Models;

use Url;
use Auth;
use Model;
use Lang;
use BackendAuth;
use ValidationException;
use Carbon\Carbon;
use Cms\Classes\Theme;
use Cms\Classes\Page as CmsPage;

use Html;
use Markdown;
use Backend\Models\User as BackendUser;
use Cms\Classes\Controller;
use October\Rain\Database\NestedTreeScope;
use RainLab\Blog\Classes\TagProcessor;

/**
 * Model
 */
class Product extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_products';
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    /*
     * Validation
     */
    public $rules = [
        'title'   => 'required',
        'slug'    => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'unique:bol_eshop_products'],
        'short_description' => 'required',
        'description' => 'required',
        'brand_id' => 'required',
        'unit_id' => 'required',
    ];

    /**
     * @var array Attributes that support translation, if available.
     */
    public $translatable = [
        'title',
        'short_description',
        'description',
        'meta_title',
        'meta_description',
        ['slug', 'index' => true]
    ];

    public $hasOne = [
        'unit'     => ['Bol\Eshop\Models\Unit', 'key' => 'id', 'otherKey' => 'unit_id'],
        'brand'    => ['Bol\Eshop\Models\Brand', 'key' => 'id', 'otherKey' => 'brand_id'],
        'supplier' => ['Bol\Eshop\Models\Supplier', 'key' => 'id', 'otherKey' => 'supplier_id'],
    ];

    public $hasMany = [
        'wish_items'       => ['Bol\Eshop\Models\WishList', 'key' => 'product_id', 'otherKey' => 'id'],
        'stocks'           => ['Bol\Eshop\Models\Stock', 'key' => 'product_id', 'otherKey' => 'id'],
        'stock_deductions' => ['Bol\Eshop\Models\StockDeduction', 'key' => 'product_id', 'otherKey' => 'id'],
    ];

    public $belongsToMany = [
        'categories' => [
            Category::class,
            'table' => 'bol_eshop_product_categories',
            'order' => 'name'
        ]
    ];

    public $attachOne = [
        'download_product'  => \System\Models\File::class
    ];

    public $attachMany = [
        'photos' => [\System\Models\File::class, 'order' => 'sort_order'],
    ];


    /**
     * @var array Attributes to be stored as JSON
     */
    protected $jsonable = ['colors', 'sizes'];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['published_at', 'deleted_at'];

    /**
     * The attributes on which the post list can be ordered.
     * @var array
     */
    public static $allowedSortingOptions = [
        'title asc'         => 'bol.eshop::lang.sorting.title_asc',
        'title desc'        => 'bol.eshop::lang.sorting.title_desc',
        'created_at asc'    => 'bol.eshop::lang.sorting.created_asc',
        'created_at desc'   => 'bol.eshop::lang.sorting.created_desc',
        'updated_at asc'    => 'bol.eshop::lang.sorting.updated_asc',
        'updated_at desc'   => 'bol.eshop::lang.sorting.updated_desc',
        'published_at asc'  => 'bol.eshop::lang.sorting.published_asc',
        'published_at desc' => 'bol.eshop::lang.sorting.published_desc',
        'random'            => 'bol.eshop::lang.sorting.random'
    ];

    /*
     * Relations
     */
    public $belongsTo = [
        'created_by_user' => ['Backend\Models\User', 'key' => 'created_by', 'otherKey' => 'id'],
        'updated_by_user' => ['Backend\Models\User', 'key' => 'updated_by', 'otherKey' => 'id']
    ];

    /**
     * @var array The accessors to append to the model's array form.
     */
    protected $appends = [];

    public $preview = null;

    /**
     * Limit visibility of the published-button
     *
     * @param       $fields
     * @param  null $context
     * @return void
     */
    public function filterFields($fields, $context = null)
    {
        if (!isset($fields->is_published, $fields->published_at)) {
            return;
        }

        $user = BackendAuth::getUser();

        if (!$user->hasAnyAccess(['bol.eshop.access_publish'])) {
            $fields->is_published->hidden = true;
            $fields->is_published_at->hidden = true;
        }
        else {
            $fields->is_published->hidden = false;
            $fields->published_at->hidden = false;
        }
    }

    public function afterValidate()
    {
        if ($this->is_published && !$this->published_at) {
            throw new ValidationException([
               'published_at' => Lang::get('bol.eshop::lang.product.published_validation')
            ]);
        }
    }

    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if (!is_null($user)) {
            $this->created_by = $user->id;
        }
    }

    public function beforeSave()
    {
        $user = BackendAuth::getUser();
        if (!is_null($user)) {
            $this->updated_by = $user->id;
        }

        if (!$this->colors) {
            $this->colors = [];
        }

        if (!$this->sizes) {
            $this->sizes = [];
        }
    }

    /**
     * Sets the "url" attribute with a URL to this object.
     * @param string $pageName
     * @param Controller $controller
     * @param array $params Override request URL parameters
     *
     * @return string
     */
    public function setUrl($pageName, $controller, $params = [])
    {
        $params = array_merge([
            'id'   => $this->id,
            'slug' => $this->slug,
        ], $params);

        if (empty($params['category'])) {
            $params['category'] = $this->categories->count() ? $this->categories->first()->slug : null;
        }

        // Expose published year, month and day as URL parameters.
        if ($this->is_published) {
            $params['year']  = $this->published_at->format('Y');
            $params['month'] = $this->published_at->format('m');
            $params['day']   = $this->published_at->format('d');
        }

        return $this->url = $controller->pageUrl($pageName, $params);
    }

    /**
     * Used to test if a certain user has permission to edit post,
     * returns TRUE if the user is the owner or has other posts access.
     * @param  BackendUser $user
     * @return bool
     */
    public function canEdit(BackendUser $user)
    {
        return ($this->user_id == $user->id) || $user->hasAnyAccess(['bol.eshop.access_other_products']);
    }

    public static function formatHtml($input, $preview = false)
    {
        $result = Markdown::parse(trim($input));

        // Check to see if the HTML should be cleaned from potential XSS
        $user = BackendAuth::getUser();
        if (!$user || !$user->hasAccess('backend.allow_unsafe_markdown')) {
            $result = Html::clean($result);
        }

        if ($preview) {
            $result = str_replace('<pre>', '<pre class="prettyprint">', $result);
        }

        $result = TagProcessor::instance()->processTags($result, $preview);

        return $result;
    }

    //
    // Scopes
    //

    public function scopeIsPublished($query)
    {
        return $query
            ->whereNotNull('is_published')
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<', Carbon::now())
        ;
    }

    /**
     * Lists posts for the frontend
     *
     * @param        $query
     * @param  array $options Display options
     * @return Post
     */
    public function scopeListFrontEnd($query, $options)
    {
        /*
         * Default options
         */
        extract(array_merge([
            'page'             => 1,
            'perPage'          => 30,
            'sort'             => 'created_at',
            'categories'       => null,
            'exceptCategories' => null,
            'category'         => null,
            'search'           => '',
            'featured'         => false,
            'published'        => true,
            'exceptPost'       => null
        ], $options));

        $searchableFields = ['title', 'slug', 'short_description', 'description'];

        if ($published) {
            $query->isPublished();
        }

        if ($featured) 
        {
            $query->where('is_featured', 1);
        }

        /*
         * Except post(s)
         */
        if ($exceptPost) {
            $exceptPosts = (is_array($exceptPost)) ? $exceptPost : [$exceptPost];
            $exceptPostIds = [];
            $exceptPostSlugs = [];

            foreach ($exceptPosts as $exceptPost) {
                $exceptPost = trim($exceptPost);

                if (is_numeric($exceptPost)) {
                    $exceptPostIds[] = $exceptPost;
                } else {
                    $exceptPostSlugs[] = $exceptPost;
                }
            }

            if (count($exceptPostIds)) {
                $query->whereNotIn('id', $exceptPostIds);
            }
            if (count($exceptPostSlugs)) {
                $query->whereNotIn('slug', $exceptPostSlugs);
            }
        }

        /*
         * Sorting
         */
        if (in_array($sort, array_keys(static::$allowedSortingOptions))) {
            if ($sort == 'random') {
                $query->inRandomOrder();
            } else {
                @list($sortField, $sortDirection) = explode(' ', $sort);

                if (is_null($sortDirection)) {
                    $sortDirection = "desc";
                }

                $query->orderBy($sortField, $sortDirection);
            }
        }

        /*
         * Search
         */
        $search = trim($search);
        if (strlen($search)) {
            $query->searchWhere($search, $searchableFields);
        }

        /*
         * Categories
         */
        if ($categories !== null) {
            $categories = is_array($categories) ? $categories : [$categories];
            $query->whereHas('categories', function($q) use ($categories) {
                $q->withoutGlobalScope(NestedTreeScope::class)->whereIn('id', $categories);
            });
        }

        /*
         * Except Categories
         */
        if (!empty($exceptCategories)) {
            $exceptCategories = is_array($exceptCategories) ? $exceptCategories : [$exceptCategories];
            array_walk($exceptCategories, 'trim');

            $query->whereDoesntHave('categories', function ($q) use ($exceptCategories) {
                $q->withoutGlobalScope(NestedTreeScope::class)->whereIn('slug', $exceptCategories);
            });
        }

        /*
         * Category, including children
         */
        if ($category !== null) {
            $category = Category::find($category);

            $categories = $category->getAllChildrenAndSelf()->lists('id');
            $query->whereHas('categories', function($q) use ($categories) {
                $q->withoutGlobalScope(NestedTreeScope::class)->whereIn('id', $categories);
            });
        }

        return $query->paginate($perPage, $page);
    }

    /**
     * Allows filtering for specifc categories.
     * @param  Illuminate\Query\Builder  $query      QueryBuilder
     * @param  array                     $categories List of category ids
     * @return Illuminate\Query\Builder              QueryBuilder
     */
    public function scopeFilterCategories($query, $categories)
    {
        return $query->whereHas('categories', function($q) use ($categories) {
            $q->withoutGlobalScope(NestedTreeScope::class)->whereIn('id', $categories);
        });
    }

    //
    // Next / Previous
    //

    /**
     * Apply a constraint to the query to find the nearest sibling
     *
     *     // Get the next post
     *     Post::applySibling()->first();
     *
     *     // Get the previous post
     *     Post::applySibling(-1)->first();
     *
     *     // Get the previous post, ordered by the ID attribute instead
     *     Post::applySibling(['direction' => -1, 'attribute' => 'id'])->first();
     *
     * @param       $query
     * @param array $options
     * @return
     */
    public function scopeApplySibling($query, $options = [])
    {
        if (!is_array($options)) {
            $options = ['direction' => $options];
        }

        extract(array_merge([
            'direction' => 'next',
            'attribute' => 'published_at'
        ], $options));

        $isPrevious = in_array($direction, ['previous', -1]);
        $directionOrder = $isPrevious ? 'asc' : 'desc';
        $directionOperator = $isPrevious ? '>' : '<';

        $query->where('id', '<>', $this->id);

        if (!is_null($this->$attribute)) {
            $query->where($attribute, $directionOperator, $this->$attribute);
        }

        return $query->orderBy($attribute, $directionOrder);
    }

    /**
     * Returns the next post, if available.
     * @return self
     */
    public function nextPost()
    {
        return self::isPublished()->applySibling()->first();
    }

    /**
     * Returns the previous post, if available.
     * @return self
     */
    public function previousPost()
    {
        return self::isPublished()->applySibling(-1)->first();
    }

    //
    // Menu helpers
    //

    /**
     * Handler for the pages.menuitem.getTypeInfo event.
     * Returns a menu item type information. The type information is returned as array
     * with the following elements:
     * - references - a list of the item type reference options. The options are returned in the
     *   ["key"] => "title" format for options that don't have sub-options, and in the format
     *   ["key"] => ["title"=>"Option title", "items"=>[...]] for options that have sub-options. Optional,
     *   required only if the menu item type requires references.
     * - nesting - Boolean value indicating whether the item type supports nested items. Optional,
     *   false if omitted.
     * - dynamicItems - Boolean value indicating whether the item type could generate new menu items.
     *   Optional, false if omitted.
     * - cmsPages - a list of CMS pages (objects of the Cms\Classes\Page class), if the item type requires a CMS page reference to
     *   resolve the item URL.
     *
     * @param string $type Specifies the menu item type
     * @return array Returns an array
     */
    public static function getMenuTypeInfo($type)
    {
        $result = [];

        if ($type == 'shop-product') {
            $references = [];

            $posts = self::orderBy('title')->get();
            foreach ($posts as $post) {
                $references[$post->id] = $post->title;
            }

            $result = [
                'references'   => $references,
                'nesting'      => false,
                'dynamicItems' => false
            ];
        }

        if ($type == 'all-shop-products') {
            $result = [
                'dynamicItems' => true
            ];
        }

        if ($type == 'category-shop-products') {
            $references = [];

            $categories = Category::orderBy('name')->get();
            foreach ($categories as $category) {
                $references[$category->id] = $category->name;
            }

            $result = [
                'references'   => $references,
                'dynamicItems' => true
            ];
        }

        if ($result) {
            $theme = Theme::getActiveTheme();

            $pages = CmsPage::listInTheme($theme, true);
            $cmsPages = [];

            foreach ($pages as $page) {
                if (!$page->hasComponent('shopProduct')) {
                    continue;
                }

                /*
                 * Component must use a categoryPage filter with a routing parameter and post slug
                 * eg: categoryPage = "{{ :somevalue }}", slug = "{{ :somevalue }}"
                 */
                $properties = $page->getComponentProperties('shopProduct');
                if (!isset($properties['categoryPage']) || !preg_match('/{{\s*:/', $properties['slug'])) {
                    continue;
                }

                $cmsPages[] = $page;
            }

            $result['cmsPages'] = $cmsPages;
        }

        return $result;
    }

    /**
     * Handler for the pages.menuitem.resolveItem event.
     * Returns information about a menu item. The result is an array
     * with the following keys:
     * - url - the menu item URL. Not required for menu item types that return all available records.
     *   The URL should be returned relative to the website root and include the subdirectory, if any.
     *   Use the Url::to() helper to generate the URLs.
     * - isActive - determines whether the menu item is active. Not required for menu item types that
     *   return all available records.
     * - items - an array of arrays with the same keys (url, isActive, items) + the title key.
     *   The items array should be added only if the $item's $nesting property value is TRUE.
     *
     * @param \RainLab\Pages\Classes\MenuItem $item Specifies the menu item.
     * @param \Cms\Classes\Theme $theme Specifies the current theme.
     * @param string $url Specifies the current page URL, normalized, in lower case
     * The URL is specified relative to the website root, it includes the subdirectory name, if any.
     * @return mixed Returns an array. Returns null if the item cannot be resolved.
     */
    public static function resolveMenuItem($item, $url, $theme)
    {
        $result = null;

        if ($item->type == 'shop-product') {
            if (!$item->reference || !$item->cmsPage) {
                return;
            }

            $category = self::find($item->reference);
            if (!$category) {
                return;
            }

            $pageUrl = self::getPostPageUrl($item->cmsPage, $category, $theme);
            if (!$pageUrl) {
                return;
            }

            $pageUrl = Url::to($pageUrl);

            $result = [];
            $result['url'] = $pageUrl;
            $result['isActive'] = $pageUrl == $url;
            $result['mtime'] = $category->updated_at;
        }
        elseif ($item->type == 'all-shop-products') {
            $result = [
                'items' => []
            ];

            $posts = self::isPublished()
                ->orderBy('title')
                ->get()
            ;

            foreach ($posts as $post) {
                $postItem = [
                    'title' => $post->title,
                    'url'   => self::getPostPageUrl($item->cmsPage, $post, $theme),
                    'mtime' => $post->updated_at
                ];

                $postItem['isActive'] = $postItem['url'] == $url;

                $result['items'][] = $postItem;
            }
        }
        elseif ($item->type == 'category-shop-products') {
            if (!$item->reference || !$item->cmsPage) {
                return;
            }

            $category = Category::find($item->reference);
            if (!$category) {
                return;
            }

            $result = [
                'items' => []
            ];

            $query = self::isPublished()
            ->orderBy('title');

            $categories = $category->getAllChildrenAndSelf()->lists('id');
            $query->whereHas('categories', function($q) use ($categories) {
                $q->withoutGlobalScope(NestedTreeScope::class)->whereIn('id', $categories);
            });

            $posts = $query->get();

            foreach ($posts as $post) {
                $postItem = [
                    'title' => $post->title,
                    'url'   => self::getPostPageUrl($item->cmsPage, $post, $theme),
                    'mtime' => $post->updated_at
                ];

                $postItem['isActive'] = $postItem['url'] == $url;

                $result['items'][] = $postItem;
            }
        }

        return $result;
    }

    /**
     * Returns URL of a post page.
     *
     * @param $pageCode
     * @param $category
     * @param $theme
     */
    protected static function getPostPageUrl($pageCode, $category, $theme)
    {
        $page = CmsPage::loadCached($theme, $pageCode);
        if (!$page) {
            return;
        }

        $properties = $page->getComponentProperties('blogPost');
        if (!isset($properties['slug'])) {
            return;
        }

        /*
         * Extract the routing parameter name from the category filter
         * eg: {{ :someRouteParam }}
         */
        if (!preg_match('/^\{\{([^\}]+)\}\}$/', $properties['slug'], $matches)) {
            return;
        }

        $paramName = substr(trim($matches[1]), 1);
        $params = [
            $paramName => $category->slug,
            'year'  => $category->published_at->format('Y'),
            'month' => $category->published_at->format('m'),
            'day'   => $category->published_at->format('d')
        ];
        $url = CmsPage::url($page->getBaseFileName(), $params);

        return $url;
    }

    public function getStockCountAttribute()
    {
        return $this->stocks()->sum('quantity') - $this->stock_deductions()->sum('quantity');
    }

    public function getShowStockAttribute()
    {
        return Settings::get('show_stock');
    }

    public function getEnablePurchaseRestrictionAttribute()
    {
        return Settings::get('enable_purchase_restriction') && $this->stock_count == 0;
    }

    public function getDefaultColorAttribute()
    {
        if(count($this->colors))
        {
            return $this->colors[0]['label'];
        }

        return '';
    }

    public function getDefaultSizeAttribute()
    {
        if(count($this->sizes))
        {
            return $this->sizes[0]['label'];
        }
        
        return '';
    }

    public function getOriginalPriceLabelAttribute()
    {
        if(Settings::get('show_currency'))
        {
            $currency = Currency::where('is_default', 1)->where('is_active', 1)->get()->first();

            if(Settings::get('currency_label') == 'symbol')
            {
                return $currency->symbol."".$this->price;
            }
            else
            {
                return $this->price." ".$currency->name;
            }
        }

        return $this->price;
    }

    public function getPriceLabelAttribute()
    {
        if(Settings::get('show_currency'))
        {
            $currency = Currency::where('is_default', 1)->where('is_active', 1)->get()->first();

            if(Settings::get('currency_label') == 'symbol')
            {
                return $currency->symbol."".$this->main_price;
            }
            else
            {
                return $this->main_price." ".$currency->name;
            }
        }

        return $this->main_price;
    }

    public function getIsWishListAttribute()
    {
        $user = Auth::getUser();

        if($user)
        {
            $item = $this->wish_items()->where('user_id', $user->id)->get()->first();
            
            if($item)
            {
                return true;
            }
        }

        return false;
    }

    public function getMainPriceAttribute()
    {
        if($this->discount)
        {
            if($this->discount_type == 'Amount')
            {
                return $this->price - $this->discount_amount;
            }
            else
            {
                return $this->price - $this->discount_amount;
            }
        }

        return $this->price;
    }

    public function getDiscountAmountAttribute()
    {
        if($this->discount)
        {
            if($this->discount_type == 'Amount')
            {
                return $this->discount;
            }
            else
            {
                return ($this->price * $this->discount) / 100;
            }
        }

        return 0;
    }

    public function getBrandIdOptions()
    {
        $options = [
            null => Lang::get('bol.eshop::lang.product.select_a_brand')
        ];

        foreach (Brand::orderBy('sort_order', 'asc')->get() as $brand) 
        {
            $options[$brand->id] = $brand->name;
        }

        return $options;
    }

    public function getUnitIdOptions()
    {
        $options = [
            //null => Lang::get('bol.eshop::lang.product.select_a_unit')
        ];

        foreach (Unit::all() as $unit) 
        {
            $options[$unit->id] = $unit->name;
        }

        return $options;
    }

    public function getSupplierIdOptions()
    {
        $options = [
            null => "Select Supplier"
        ];

        foreach (Supplier::get() as $item) 
        {
            $options[$item->id] = $item->name;
        }

        return $options;
    }

    public function featuredPhoto($imageWidth = null, $imageHeight = null)
    {
        return isset($this->photos[0]) ? (($imageHeight && $imageWidth) ? $this->photos[0]->getThumb($imageWidth, $imageHeight, ['mode' => 'crop']) : $this->photos[0]->getPath()) :  (($imageHeight && $imageWidth) ? "https://dummyimage.com/$imageWidth"."x"."$imageHeight/e3e3e3/d5aa6d.jpg&text=++Product++" : "https://dummyimage.com/200x200/e3e3e3/d5aa6d.jpg&text=++Product++");
    }

    public function hoverPhoto($imageWidth = null, $imageHeight = null)
    {
        return isset($this->photos[1]) ? (($imageHeight && $imageWidth) ? $this->photos[1]->getThumb($imageWidth, $imageHeight, ['mode' => 'crop']) : $this->photos[1]->getPath()) :  (($imageHeight && $imageWidth) ? "https://dummyimage.com/$imageWidth"."x"."$imageHeight/e3e3e3/d5aa6d.jpg&text=++Product+Hover++" : "https://dummyimage.com/200x200/e3e3e3/d5aa6d.jpg&text=++Product+Hover++");
    }
}
