<?php namespace Bol\Eshop\Models;

use Model;

/**
 * Model
 */
class Currency extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_currencies';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
