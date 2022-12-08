<?php namespace Bol\Eshop\Models;

use Model;

/**
 * Model
 */
class Purchase extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_purchases';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
