<?php namespace Bol\Eshop\Models;

use Model;

/**
 * Model
 */
class StockDeduction extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_stock_deductions';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
