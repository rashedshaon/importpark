<?php namespace Bol\Eshop\Models;

use Model;

/**
 * Model
 */
class City extends Model
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
    public $table = 'bol_eshop_cities';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $hasOne = [
        'region' => ['Bol\Eshop\Models\Region', 'key' => 'id', 'otherKey' => 'region_id'],
    ];

    public $hasMany = [
        'areas' => ['Bol\Eshop\Models\Area', 'key' => 'city_id', 'otherKey' => 'id'],
    ];
}
