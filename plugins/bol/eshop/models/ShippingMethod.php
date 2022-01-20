<?php namespace Bol\Eshop\Models;

use Model;

/**
 * Model
 */
class ShippingMethod extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_shipping_methods';

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

    public function getPriceLabelAttribute()
    {
        if(Settings::get('show_currency'))
        {
            $currency = Currency::where('is_default', 1)->where('is_active', 1)->get()->first();

            if(Settings::get('currency_label') == 'symbol')
            {
                return $currency->symbol." ".$this->price;
            }
            else
            {
                return $this->price." ".$currency->name;
            }
        }

        return $this->price;
    }
}
