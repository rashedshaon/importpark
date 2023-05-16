<?php namespace Bol\Eshop\Models;

use Model;
use Lang;
use BackendAuth;

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
        'order' => ['Bol\Eshop\Models\Order', 'key' => 'id', 'otherKey' => 'order_id'],
        'created_by_user'  => ['RainLab\User\Models\User', 'key' => 'id', 'otherKey' => 'created_by'],
        'updated_by_user'  => ['RainLab\User\Models\User', 'key' => 'id', 'otherKey' => 'updated_by'],
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

    public function getActualPriceLabelAttribute()
    {
        if(Settings::get('show_currency'))
        {
            $currency = Currency::where('is_default', 1)->where('is_active', 1)->get()->first();

            if(Settings::get('currency_label') == 'symbol')
            {
                return $currency->symbol."".number_format($this->actual_price);
            }
            else
            {
                return number_format($this->actual_price)." ".$currency->name;
            }
        }

        return $this->actual_price;
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
            return $options[$item->id] = $item->title.' ('.$item->id.')';
        });

        return $options;
    }

    public function beforeCreate()
    {
        $product = Product::find($this->product_id);
        $this->title = $product->title;
        $this->actual_price = $product->price;
        $this->unit = $product->unit->name;

        $user = BackendAuth::getUser();
        $this->created_by = $user->id;
    }

    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        $this->updated_by = $user->id;
    }

    public function afterCreate()
    {
        /**
         * When product stock quantity will deduct
         */
        if(Settings::get('enable_purchase_restriction'))
        {
            if($this->order->status_id == Settings::get('inventory_deduction'))
            {
                $stock_deduction = new StockDeduction();
                $stock_deduction->order_id = $this->order_id;
                $stock_deduction->product_id = $this->product_id;
                $stock_deduction->sale_price = $this->price;
                $stock_deduction->quantity = $this->quantity;
                $stock_deduction->save();
            }
        }
    }

    public function afterDelete()
    {
        /**
         * When order item will be delete remove stock deduction
         */

        StockDeduction::where('order_id', $this->order_id)->where('product_id', $this->product_id)->delete();
    }

    public function filterFields($fields, $context = null)
    {
        if($context == 'create')
        {
            if(!empty($this->product_id))
            {
                $price = Product::find($this->product_id)->price;
                $fields->price->value = round($price);
            }
        }
    }

    public function scopeOwnList($query)
    {
        $user = BackendAuth::getUser();
        return $query->where('created_by', $user->id);
    }
}
