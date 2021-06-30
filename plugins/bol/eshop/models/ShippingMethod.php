<?php namespace Bol\Eshop\Models;

use Model;

/**
 * Model
 */
class ShippingMethod extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_shipping_methods';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
