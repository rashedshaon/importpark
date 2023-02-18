<?php namespace Bol\Eshop\Models;

use Model;

/**
 * Model
 */
class CartItem extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_cart_items';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $hasOne = [
        'product' => ['Bol\Eshop\Models\Product', 'key' => 'id', 'otherKey' => 'product_id'],
    ];

    public function getPriceLabelAttribute()
    {
        if(Settings::get('show_currency'))
        {
            $currency = Currency::where('is_default', 1)->where('is_active', 1)->get()->first();

            if(Settings::get('currency_label') == 'symbol')
            {
                return $currency->symbol."".number_format($this->price);
            }
            else
            {
                return number_format($this->price)." ".$currency->name;
            }
        }

        return $this->main_price;
    }

    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    public function getSubtotalLabelAttribute()
    {
        if(Settings::get('show_currency'))
        {
            $currency = Currency::where('is_default', 1)->where('is_active', 1)->get()->first();

            if(Settings::get('currency_label') == 'symbol')
            {
                return $currency->symbol."".$this->subtotal;
            }
            else
            {
                return $this->subtotal." ".$currency->name;
            }
        }

        return $this->subtotal;
    }

    public function getDiscountSubtotalAttribute()
    {
        return ($this->product->price - $this->price) * $this->quantity;
    }
}
