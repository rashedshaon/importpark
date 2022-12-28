<?php namespace Bol\Eshop\Models;

use Model;

/**
 * Model
 */
class PurchaseItem extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_purchase_items';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function getProductIdOptions()
    {
        $options = [
            null => "Select Product"
        ];

        foreach (Product::get() as $item) 
        {
            $options[$item->id] = $item->title;
        }

        return $options;
    }
}
