<?php namespace Bol\Eshop\Models;

use October\Rain\Database\Model;

/**
 * Settings Model
 */
class Settings extends Model
{

    public $settingsCode = 'bol_eshop_settings';

    public $implement = [
        'System.Behaviors.SettingsModel',
        '@RainLab.Translate.Behaviors.TranslatableModel',
    ];

    public $translatable = [];
    public $settingsFields = 'fields.yaml';

    public $attachOne = [];
    public $attachMany = [];

    public function initSettingsData()
    {

    }

    // /**
    //  * Get measure list
    //  * @return array
    //  */
    // public function getDimensionsMeasureOptions()
    // {
    //     $arResult = (array) Measure::orderBy('name', 'asc')->lists('name', 'id');

    //     return $arResult;
    // }

    // /**
    //  * Get measure list
    //  * @return array
    //  */
    // public function getWeightMeasureOptions()
    // {
    //     $arResult = (array) Measure::orderBy('name', 'asc')->lists('name', 'id');

    //     return $arResult;
    // }

    // /**
    //  * Get measure list
    //  * @return array
    //  */
    // public function getMeasureOfUnitOptions()
    // {
    //     $arResult = (array) Measure::orderBy('name', 'asc')->lists('name', 'id');

    //     return $arResult;
    // }
}
