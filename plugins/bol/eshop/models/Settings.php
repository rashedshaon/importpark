<?php namespace Bol\Eshop\Models;

use October\Rain\Database\Model;
use Lang;
use System\Models\MailTemplate;


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

    
    public $attachOne = [
        'site_logo'  => \System\Models\File::class
    ];

    public $attachMany = [];

    public function initSettingsData()
    {
        $this->show_currency = 1;
        $this->currency_label = 'symbol';
    }

    public function getInventoryDeductionOptions()
    {
        $options = [
            null => Lang::get('bol.eshop::lang.order_status.select_status'),
        ];

        $items = OrderStatus::orderBy('sort_order', 'asc')->get();
        $items->each(function ($item) use (&$options) {
            return $options[$item->id] = $item->name;
        });

        return $options;
    }

    public function getInventoryRevertDeductionOptions()
    {
        $options = [
            null => Lang::get('bol.eshop::lang.order_status.select_status'),
        ];

        $items = OrderStatus::orderBy('sort_order', 'asc')->get();
        $items->each(function ($item) use (&$options) {
            return $options[$item->id] = $item->name;
        });

        return $options;
    }

    public function getInitialOrderStatusOptions()
    {
        $options = [
            null => Lang::get('bol.eshop::lang.order_status.select_status'),
        ];

        $items = OrderStatus::orderBy('sort_order', 'asc')->get();
        $items->each(function ($item) use (&$options) {
            return $options[$item->id] = $item->name;
        });

        return $options;
    }

    public function getOrderStatusOptions()
    {
        $options = [
            null => Lang::get('bol.eshop::lang.order_status.select_status'),
        ];

        $items = OrderStatus::orderBy('sort_order', 'asc')->get();
        $items->each(function ($item) use (&$options) {
            return $options[$item->id] = $item->name;
        });

        return $options;
    }

    public function getEmailTemplateOptions()
    {
        $options = [
            null => Lang::get('bol.eshop::lang.order_status.select_mail_template'),
        ];

        $items = MailTemplate::get();
        $items->each(function ($item) use (&$options) {
            return $options[$item->code] = $item->code;
        });

        return $options;
    }

    public static function siteLogo($imageWidth = null, $imageHeight = null)
    {
        $settings = self::instance();

        return isset($settings->site_logo) ? (($imageHeight && $imageWidth) ? $settings->site_logo->getThumb($imageWidth, $imageHeight, ['mode' => 'crop']) : $settings->site_logo->getPath()) :  (($imageHeight && $imageWidth) ? "https://dummyimage.com/$imageWidth"."x"."$imageHeight/e3e3e3/d5aa6d.jpg&text=++logo++" : "https://dummyimage.com/174x80/e3e3e3/d5aa6d.jpg&text=++logo++");
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
