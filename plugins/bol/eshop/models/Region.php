<?php namespace Bol\Eshop\Models;

use Model;

/**
 * Model
 */
class Region extends Model
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
    public $table = 'bol_eshop_regions';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $hasMany = [
        'cities' => ['Bol\Eshop\Models\City', 'key' => 'region_id', 'otherKey' => 'id'],
    ];
}
