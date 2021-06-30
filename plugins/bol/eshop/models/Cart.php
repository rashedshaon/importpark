<?php namespace Bol\Eshop\Models;

use Model;

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
    public $rules = [
    ];
}
