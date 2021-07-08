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

    public function getSubtotalAttribute()
    {
        return $this->product->main_price * $this->quantity;
    }

    public function getDiscountSubtotalAttribute()
    {
        return $this->product->discount_amount * $this->quantity;
    }
}
