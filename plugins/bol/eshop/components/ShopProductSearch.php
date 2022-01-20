<?php namespace Bol\Eshop\Components;

use Lang;
use Auth;
use Flash;
use Redirect;
use Cms\Classes\ComponentBase;
use October\Rain\Database\Model;
use Bol\Eshop\Models\Product;

class ShopProductSearch extends ComponentBase
{
    /**
     * A collection of products to display
     *
     * @var Collection
     */
    public $products;


    public function componentDetails()
    {
        return [
            'name'        => 'bol.eshop::lang.search.title',
            'description' => 'bol.eshop::lang.search.description'

        ];
    }

    public function defineProperties()
    {
        return [];
    }


    public function onRun()
    {
        $this->products = $this->page['products'] = Product::orderBy('id','desc')->paginate(10, 1);
    }

    public function onSearchItem()
    {
        $search = post('search');

        $this->products = $this->page['products'] = Product::where('title', 'like', '%'.$search.'%')->orderBy('id','desc')->paginate(20, 1);

        return [
            '.search-items' => $this->renderPartial('@list-items')
        ];
    }

    public function onScrollSearchList()
    {
        $page = post('page') ?? 1;

        $this->products = $this->page['products'] = Product::orderBy('id','desc')->paginate(10, $page);

        return [
            '@.search-items' => $this->renderPartial('@list-items')
        ];
    }
}

