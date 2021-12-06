<?php namespace Bol\Eshop\Models;

use Model;

/**
 * Model
 */
class Order extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_orders';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $jsonable = [
        'delivery_address',
        'billing_address',
    ];

    public $hasMany = [
        'items' => ['Bol\Eshop\Models\OrderItem', 'key' => 'cart_id', 'otherKey' => 'id'],
    ];
}
