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

    public $hasOne = [
        'supplier' => ['Bol\Eshop\Models\Supplier', 'key' => 'id', 'otherKey' => 'supplier_id'],
        'status'   => ['Bol\Eshop\Models\PurchaseStatus', 'key' => 'id', 'otherKey' => 'status_id'],
    ];

    public $hasMany = [
        'purchase_items' => ['Bol\Eshop\Models\PurchaseItem', 'key' => 'purchase_id', 'otherKey' => 'id'],
    ];

    public function getSupplierIdOptions()
    {
        $options = [
            null => "Select Supplier"
        ];

        foreach (Supplier::get() as $item) 
        {
            $options[$item->id] = $item->name;
        }

        return $options;
    }

    public function getStatusIdOptions()
    {
        $options = [];

        foreach (PurchaseStatus::get() as $item) 
        {
            $options[$item->id] = $item->name;
        }

        return $options;
    }
}
