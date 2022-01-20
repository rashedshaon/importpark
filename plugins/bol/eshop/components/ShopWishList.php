<?php namespace Bol\Eshop\Components;

use Cms\Classes\ComponentBase;
use Event;
use Lang;
use Auth, AuthException;
use Flash;
use Request;
use Validator, ValidationException;
use RainLab\User\Models\Settings as UserSettings;
use Bol\Eshop\Models\WishList;

class ShopWishList extends ComponentBase
{

    public $wishlist;
    public $wishlist_count;


    public function componentDetails()
    {
        return [
            'name'        => 'bol.eshop::lang.wishlist.title',
            'description' => 'bol.eshop::lang.wishlist.description'
        ];
    }

    public function defineProperties()
    {
        return [];
    }


    public function onRun()
    {
        $this->prepareVars();
    }

    protected function prepareVars()
    {
        $this->wishlist = $this->page['items'] = WishList::getList(10, 1);

        $this->wishlist_count = $this->page['wishlist_count'] = WishList::itemCount();
    }

    

    public function onScrollList()
    {
        $page = post('page') ?? 1;

        $this->page['items'] = WishList::getList(10, $page);

        return [
            '@.wishlist-items' => $this->renderPartial('@wishlist-items')
        ];
    }

    /**
     * 
     * 
     */
    public function onAddOrRemoveWishlist()
    {
        $post = post();

        $action = Wishlist::addOrRemove($post['product_id']);

        $this->page['wishlist_count'] = WishList::itemCount();

        if($action)
        {
            Flash::success(Lang::get('bol.eshop::lang.wishlist.successfully_added_to_wishlist'));

            return  [
                '.wishlist-count' => $this->renderPartial('@wishlist-count'), 
                '#icon'.$post['product_id'] => '<i class="fad fa-heart"></i>', 
            ];
        }
        else
        {
            Flash::error(Lang::get('bol.eshop::lang.wishlist.successfully_remove_to_wishlist'));
            return  [
                '.wishlist-count' => $this->renderPartial('@wishlist-count'), 
                '#icon'.$post['product_id'] => '<i class="fal fa-heart"></i>', 
            ];
        }
    }


    public function onWishlistRemove()
    {
        $post = post();
       
        Wishlist::removeItem($post['id']);

        Flash::error(Lang::get('bol.eshop::lang.wishlist.successfully_remove_to_wishlist'));
        
        $this->page['items'] = WishList::getList(10, 1);
        $this->page['wishlist_count'] = WishList::itemCount();

        return  [
                    '.wishlist-count' => $this->renderPartial('@wishlist-count'), 
                    '.wishlist-items' => $this->renderPartial('@wishlist-items'),
                ];
    }
}

