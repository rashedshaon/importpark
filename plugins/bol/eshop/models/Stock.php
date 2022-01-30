<?php namespace Bol\Eshop\Models;

use Model;
use Lang;
use BackendAuth;

/**
 * Model
 */
class Stock extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_stocks';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $hasOne = [
        'product' => ['Bol\Eshop\Models\Product', 'key' => 'id', 'otherKey' => 'product_id'],
        'vendor' => ['Bol\Eshop\Models\Vendor', 'key' => 'id', 'otherKey' => 'vendor_id'],
        'created_by_user'  => ['Backend\Models\User', 'key' => 'id', 'otherKey' => 'created_by'],
    ];

    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        $this->created_by = $user->id;
    }

    public function getProductIdOptions()
    {
        $options = [
            null => Lang::get('bol.eshop::lang.stock.select_a_product')
        ];

        foreach (Product::get() as $data) 
        {
            $options[$data->id] = $data->title;
        }

        return $options;
    }

    public function getVendorIdOptions()
    {
        $options = [
            null => Lang::get('bol.eshop::lang.stock.select_a_vendor')
        ];

        foreach (Vendor::get() as $data) 
        {
            $options[$data->id] = $data->name;
        }

        return $options;
    }
}
