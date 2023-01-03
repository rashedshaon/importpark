<?php namespace Bol\Eshop\Models;

use Model;

/**
 * Model
 */
class Supplier extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_suppliers';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $attachOne = [
        'wechat_qr'  => \System\Models\File::class,
        'alipay_qr'  => \System\Models\File::class
    ];
}
