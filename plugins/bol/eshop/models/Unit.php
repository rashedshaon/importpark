<?php namespace Bol\Eshop\Models;

use Model;

/**
 * Model
 */
class Unit extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_unit_list';

    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    /**
     * @var array Attributes that support translation, if available.
     */
    public $translatable = [
        'name',
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
