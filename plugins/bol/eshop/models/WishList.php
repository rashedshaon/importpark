<?php namespace Bol\Eshop\Models;

use Model;

/**
 * Model
 */
class WishList extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_wish_list';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public static function addItem($product_id)
    {
        $user = Auth::getUser();

        $wishlist = self::where('product_id', $product_id)
                        ->where('user_id', $user->id)->get()->first();
        
        if($wishlist)
        {
            $cart_item->increment('quantity', $quantity);
        }
        else
        {
            $wishlist             = new WishList();
            $wishlist->user_id    = $user->id;
            $wishlist->product_id = $product_id;
            $wishlist->save();
        }
    }
}
