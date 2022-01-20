<?php namespace Bol\Eshop\Models;

use Model;
use Auth;

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
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'product_id' => 'required',
        'user_id' => 'required',
    ];

    public $hasOne = [
        'product' => ['Bol\Eshop\Models\Product', 'key' => 'id', 'otherKey' => 'product_id'],
    ];


    public static function itemCount()
    {
        $user = Auth::getUser();

        if($user)
        {
            return self::where('user_id', $user->id)->count();
        }
        
        return 0;
    }

    public static function getList($limit, $page)
    {
        $user = Auth::getUser();

        if($user)
        {
            return self::where('user_id', $user->id)->orderBy('id', 'desc')->paginate($limit, $page);
        }
        
        return [];
    }

    public static function addOrRemove($product_id)
    {
        $user = Auth::getUser();

        $wishlist_item = self::where('user_id', $user->id)->where('product_id', $product_id)->first();

        if(!$wishlist_item)
        {
            $wish_List             = new WishList();
            $wish_List->user_id    = $user->id;
            $wish_List->product_id = $product_id;
            $wish_List->save();

            return true;
        }
        else
        {
            $wishlist_item->delete();

            return false;
        }
    }
    
    public static function removeItem($item_id)
    {
        self::find($item_id)->delete();
    }
}
