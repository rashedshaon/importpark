<?php namespace Bol\Eshop\Models;

use Model;
use October\Rain\Database\Traits\Sortable;

/**
 * Model
 */
class Brand extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use Sortable;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_brands';

    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required',
        'slug' => 'required|between:3,64|unique:bol_eshop_brands',
    ];

    /**
     * @var array Attributes that support translation, if available.
     */
    public $translatable = [
        'name',
        'description',
        ['slug', 'index' => true]
    ];

    public $attachOne = [
        'logo'  => \System\Models\File::class
    ];

    
}
