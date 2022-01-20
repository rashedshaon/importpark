<?php namespace Bol\Eshop\Models;

use Model;
use Lang;

/**
 * Model
 */
class OrderItem extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_order_items';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $hasOne = [
        'product' => ['Bol\Eshop\Models\Product', 'key' => 'id', 'otherKey' => 'product_id'],
    ];

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
                return $currency->symbol."".number_format($this->subtotal);
            }
            else
            {
                return number_format($this->subtotal)." ".$currency->name;
            }
        }

        return $this->subtotal;
    }

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

        return $this->price;
    }

    public function getDiscountSubtotalAttribute()
    {
        return ($this->actual_price - $this->price) * $this->quantity;
    }

    public function getProductIdOptions()
    {
        $options = [
            null => Lang::get('bol.eshop::lang.order.select_product'),
        ];

        $items = Product::get();
        $items->each(function ($item) use (&$options) {
            return $options[$item->id] = $item->title;
        });

        return $options;
    }
}
