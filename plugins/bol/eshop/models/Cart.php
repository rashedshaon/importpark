<?php namespace Bol\Eshop\Models;

use Model;
use Auth;
use Session;
use Cookie;

/**
 * Model
 */
class Cart extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_carts';

    /**
     * @var array Validation rules
     */
    public $rules = [];

    public $hasOne = [
        'user' => ['RainLab\User\Models\User', 'key' => 'id', 'otherKey' => 'user_id'],
    ];

    public $hasMany = [
        'items' => ['Bol\Eshop\Models\CartItem', 'key' => 'cart_id', 'otherKey' => 'id'],
    ];


    public function getSubtotalAttribute()
    {
        $total = 0;

        foreach($this->items()->get() as $item)
        {
            $total = $total + $item->subtotal;
        }

        return $total;
    }

    public function getSubtotalLabelAttribute()
    {
        if(Settings::get('show_currency'))
        {
            $currency = Currency::where('is_default', 1)->where('is_active', 1)->get()->first();

            if(Settings::get('currency_label') == 'symbol')
            {
                return $currency->symbol." ".$this->total;
            }
            else
            {
                return $this->total." ".$currency->name;
            }
        }

        return $this->total;
    }


    public function getTotalAttribute()
    {
        $total = 0;

        foreach($this->items()->get() as $item)
        {
            $total = $total + $item->subtotal;
        }

        return $total;
    }

    public function getTotalLabelAttribute()
    {
        if(Settings::get('show_currency'))
        {
            $currency = Currency::where('is_default', 1)->where('is_active', 1)->get()->first();

            if(Settings::get('currency_label') == 'symbol')
            {
                return $currency->symbol." ".$this->total;
            }
            else
            {
                return $this->total." ".$currency->name;
            }
        }

        return $this->total;
    }

    public function getTotalDiscountAttribute()
    {
        $total = 0;
        
        foreach($this->items()->get() as $item)
        {
            $total = $total + $item->discount_subtotal;
        }

        return $total;
    }

    public function getTotalDiscountLabelAttribute()
    {
        if(Settings::get('show_currency'))
        {
            $currency = Currency::where('is_default', 1)->where('is_active', 1)->get()->first();

            if(Settings::get('currency_label') == 'symbol')
            {
                return $currency->symbol." ".$this->total_discount;
            }
            else
            {
                return $this->total_discount." ".$currency->name;
            }
        }

        return $this->total_discount;
    }

    public function getCouponDiscountAttribute()
    {
        return 0;
    }

    public static function addToCart($product_id, $quantity, $color, $size)
    {
        $session_id = self::getSessionId();
        $cart = self::where('session_id', $session_id)->get()->first();
        
        if(!$cart)
        {
            $cart = new Cart();
            $cart->session_id = $session_id;

            $user = Auth::getUser();
            if($user)
            {
                $cart->user_id = $user->id;
            }
            $cart->save();
        }

        $cart_item = CartItem::where('cart_id', $cart->id)
                             ->where('product_id', $product_id)
                             ->where('color', $color)
                             ->where('size', $size)
                             ->get()->first();
        if($cart_item)
        {
            $cart_item->increment('quantity', $quantity);
        }
        else
        {
            $cart_item             = new CartItem();
            $cart_item->cart_id    = $cart->id;
            $cart_item->product_id = $product_id;
            $cart_item->color      = $color;
            $cart_item->size       = $size;
            $cart_item->quantity   = $quantity;
            $cart_item->save();
        }
    }

    public static function updateCartItem($item_id, $quantity)
    {
        $cart_item = CartItem::find($item_id);
        $cart_item->quantity = $quantity;
        $cart_item->save();
    }

    public static function removeCartItem($item_id)
    {
        CartItem::find($item_id)->delete();
    }

    public static function clearCart()
    {
        $session_id = self::getSessionId();
        $cart = self::where('session_id', $session_id)->get()->first();
        
        if($cart)
        {
            CartItem::where('cart_id', $cart->id)->delete();
        }
    }

    public static function data()
    {
        $session_id = self::getSessionId();
        return self::where('session_id', $session_id)->get()->first();
    }

    public static function count()
    {
        $session_id = self::getSessionId();
        $cart = self::where('session_id', $session_id)->get()->first();
        
        if($cart)
        {
            return $cart->items()->sum('quantity');
        }

        return 0;
    }

    // public static function getSessionId()
    // {
    //     if (!Session::get('cart_id')) 
    //     {
    //         $cart_id = time().rand('00000', '99999');
    //         Session::put('cart_id', $cart_id);
    //         return $cart_id;
    //     }

    //     return Session::get('cart_id');
    // }
    public static function getSessionId()
    {
        if (!Cookie::get('cart_id')) 
        {
            $cart_id = time().rand('00000', '99999');
            Cookie::queue(Cookie::forever('cart_id', $cart_id));
            return $cart_id;
        }

        return Cookie::get('cart_id');
    }
}
