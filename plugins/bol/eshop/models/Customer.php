<?php namespace Bol\Eshop\Models;

use Model;
use Carbon\Carbon;
use BackendAuth;

/**
 * Model
 */
class Customer extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'users';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name'      => 'required',
        'type_id'   => 'required',
        'phone'     => 'required|regex:/^[0-1]{2}[0-9]{9}$/|min:11|unique:users',
        // 'region_id' => 'required',
        // 'city_id'   => 'required',
        // 'area_id'   => 'required',
        // 'address'   => 'required',
    ];

    public $hasOne = [
        'region' => ['Bol\Eshop\Models\Region', 'key' => 'id', 'otherKey' => 'region_id'],
        'city'   => ['Bol\Eshop\Models\City', 'key' => 'id', 'otherKey' => 'city_id'],
        'area'   => ['Bol\Eshop\Models\Area', 'key' => 'id', 'otherKey' => 'area_id'],
        'type'   => ['Bol\Eshop\Models\CustomerType', 'key' => 'id', 'otherKey' => 'type_id'],
        'created_by_user'  => ['Bol\Eshop\Models\User', 'key' => 'id', 'otherKey' => 'created_by'],
        'updated_by_user'  => ['Bol\Eshop\Models\User', 'key' => 'id', 'otherKey' => 'updated_by'],
    ];

    public function beforeCreate()
    {
        $this->password = '87654321';

        $user = BackendAuth::getUser();
        $this->created_by = $user->id;
    }

    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        $this->updated_by = $user->id;
    }

    public function getTypeIdOptions()
    {
        $options = [];

        foreach (CustomerType::get() as $item) 
        {
            $options[$item->id] = $item->name;
        }

        return $options;
    }

    public function getRegionIdOptions()
    {
        $options = [
            null => 'Select Region'
        ];

        foreach (Region::orderBy('name', 'asc')->get() as $item) 
        {
            $options[$item->id] = $item->name;
        }

        return $options;
    }

    public function getCityIdOptions()
    {
        $options = [
            null => 'Select City'
        ];

        if($this->region_id)
        {
            foreach (City::where('region_id', $this->region_id)->orderBy('name', 'asc')->get() as $item) 
            {
                $options[$item->id] = $item->name;
            }
        }

        return $options;
    }

    public function getAreaIdOptions()
    {
        $options = [
            null => 'Select Area'
        ];

        if($this->city_id)
        {
            foreach (Area::where('city_id', $this->city_id)->orderBy('name', 'asc')->get() as $item) 
            {
                $options[$item->id] = $item->name;
            }
        }

        return $options;
    }

    public static function remainderCount()
    {
        $start_of_day = Carbon::today()->startOfDay();

        $query = self::where('has_remainder', 1)->whereDate('remainder_date', '<=', $start_of_day);

        return $query->count();
    }
}
