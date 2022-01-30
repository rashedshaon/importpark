<?php namespace Bol\Eshop\Models;

use Model;

/**
 * Model
 */
class Vendor extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_vendor';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsToMany = [
        'products' => [
            Product::class,
            'table' => 'bol_eshop_vendor_products',
            'order' => 'title'
        ]
    ];
}
