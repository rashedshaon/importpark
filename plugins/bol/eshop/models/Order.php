<?php namespace Bol\Eshop\Models;

use Model;
use Lang;
use Auth;
use BackendAuth;
use Carbon\Carbon;
use October\Rain\Argon\Argon;
use RainLab\User\Models\User;

/**
 * Model
 */
class Order extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bol_eshop_orders';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'status_id'          => 'required',
        'payment_method_id'  => 'required',
        'shipping_method_id' => 'required',
        'user_id'            => 'required',
    ];

    public $hasOne = [
        'status'          => ['Bol\Eshop\Models\OrderStatus', 'key' => 'id', 'otherKey' => 'status_id'],
        'shipping_method' => ['Bol\Eshop\Models\ShippingMethod', 'key' => 'id', 'otherKey' => 'shipping_method_id'],
        'payment_method'  => ['Bol\Eshop\Models\PaymentMethod', 'key' => 'id', 'otherKey' => 'payment_method_id'],
        'created_by_user'  => ['Backend\Models\User', 'key' => 'id', 'otherKey' => 'created_by'],
        'updated_by_user'  => ['Backend\Models\User', 'key' => 'id', 'otherKey' => 'updated_by'],
    ];

    public $hasMany = [
        'items' => ['Bol\Eshop\Models\OrderItem', 'key' => 'order_id', 'otherKey' => 'id'],
    ];

    public $jsonable = [
        'delivery_address',
        'billing_address',
    ];


    public function getTaxAmountAttribute()
    {
        if($this->tax_percent)
        {
            $total = 0;

            foreach($this->items()->get() as $item)
            {
                $total = $total + $item->subtotal;
            }

            if(Settings::get('tax_apply_on') == 'only_products')
            {
                return ($total * $this->tax_percent) / 100;
            }
            else
            {
                return (($total + $this->shipping_method->price) * $this->tax_percent) / 100;
            }
        }

        return 0;
    }


    public function getTaxAmountLabelAttribute()
    {
        if(Settings::get('show_currency'))
        {
            $currency = Currency::where('is_default', 1)->where('is_active', 1)->get()->first();

            if(Settings::get('currency_label') == 'symbol')
            {
                return $currency->symbol."".number_format($this->tax_amount);
            }
            else
            {
                return number_format($this->tax_amount)." ".$currency->name;
            }
        }

        return $this->tax_amount;
    }

    public function getSubtotalAttribute()
    {
        $total = 0;

        foreach($this->items()->get() as $item)
        {
            $total = $total + $item->subtotal;
        }

        return $total;
    }

    public function getSubtotalLabelAttribute()
    {
        if(Settings::get('show_currency'))
        {
            $currency = Currency::where('is_default', 1)->where('is_active', 1)->get()->first();

            if(Settings::get('currency_label') == 'symbol')
            {
                return $currency->symbol."".number_format($this->subtotal);
            }
            else
            {
                return number_format($this->subtotal)." ".$currency->name;
            }
        }

        return $this->subtotal;
    }

    public function getTotalDiscountAttribute()
    {
        $total = 0;
        
        foreach($this->items()->get() as $item)
        {
            $total = $total + $item->discount_subtotal;
        }

        
        if($this->other_deduction)
        {
            $total = $total + $this->other_deduction;
        }

        return $total;
    }

    public function getTotalDiscountLabelAttribute()
    {
        if(Settings::get('show_currency'))
        {
            $currency = Currency::where('is_default', 1)->where('is_active', 1)->get()->first();

            if(Settings::get('currency_label') == 'symbol')
            {
                return $currency->symbol." ".$this->total_discount;
            }
            else
            {
                return $this->total_discount." ".$currency->name;
            }
        }

        return $this->total_discount;
    }

    public function getShippingCostLabelAttribute()
    {
        if(Settings::get('show_currency'))
        {
            $currency = Currency::where('is_default', 1)->where('is_active', 1)->get()->first();

            if(Settings::get('currency_label') == 'symbol')
            {
                return $currency->symbol."".$this->shipping_method->price;
            }
            else
            {
                return $this->shipping_method->price." ".$currency->name;
            }
        }

        return $this->shipping_method->price;
    }

    public function getCouponDiscountAttribute()
    {
        return 0;
    }


    public function getTotalAttribute()
    {
        $total = 0;

        foreach($this->items()->get() as $item)
        {
            $total = $total + $item->subtotal;
        }

        //add shipping cost
        $total = $total + $this->shipping_method->price;

        //add tax amount
        $total = $total + $this->tax_amount;

        //other discount
        $total = $total - $this->other_deduction;

        return $total;
    }

    public function getTotalLabelAttribute()
    {
        if(Settings::get('show_currency'))
        {
            $currency = Currency::where('is_default', 1)->where('is_active', 1)->get()->first();

            if(Settings::get('currency_label') == 'symbol')
            {
                return $currency->symbol." ".number_format($this->total);
            }
            else
            {
                return number_format($this->total)." ".$currency->name;
            }
        }

        return $this->total;
    }



    public function getStatusIdOptions()
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

    public function getUserIdOptions()
    {
        $options = [
            0 => Lang::get('bol.eshop::lang.order.select_user'),
        ];

        $items = User::orderBy('id', 'desc')->get();
        $items->each(function ($item) use (&$options) {
            return $options[$item->id] = $item->name.' ('.$item->phone.')';
        });

        return $options;
    }

    public function getPaymentMethodIdOptions()
    {
        $options = [
            null => Lang::get('bol.eshop::lang.order.select_payment_method'),
        ];

        $items = PaymentMethod::orderBy('sort_order', 'asc')->get();
        $items->each(function ($item) use (&$options) {
            return $options[$item->id] = $item->name;
        });

        return $options;
    }

    public function getShippingMethodIdOptions()
    {
        $options = [
            null => Lang::get('bol.eshop::lang.order.select_shipping_method'),
        ];

        $items = ShippingMethod::orderBy('sort_order', 'asc')->get();
        $items->each(function ($item) use (&$options) {
            return $options[$item->id] = $item->name;
        });

        return $options;
    }

    public function getCouponIdOptions()
    {
        // $options = [
        //     null => Lang::get('bol.eshop::lang.order.select_coupon'),
        // ];

        // $items = Coupon::orderBy('sort_order', 'asc')->get();
        // $items->each(function ($item) use (&$options) {
        //     return $options[$item->id] = $item->name;
        // });

        // return $options;
        return [];
    }

    /**
     * Generate secret key
     * @return string
     */
    public function generateSecretKey()
    {
        return md5($this->order_number.(string) microtime(true));
    }

    /**
     * Before create model method
     */
    public function beforeCreate()
    {
        //Generate new order number
        $this->generateOrderNumber();

        $this->status_id = Settings::get('initial_order_status');

        if(!count($this->billing_address))
        {
            $this->billing_address = $this->delivery_address;
        }

        $user = BackendAuth::getUser();
        $this->created_by = $user->id;
    }

    public function beforeUpdate()
    {
        $user = BackendAuth::getUser();
        $this->updated_by = $user->id;
    }

    public function beforeSave()
    {
        $customer = Customer::find($this->user_id);

        $this->customer_name = $customer->name;
        $this->phone = $customer->phone;

        $this->delivery_address = [
            'name'    => $customer->name,
            'phone'   => $customer->phone,
            'email'   => $customer->email,
            'region'  => $customer->region->name,
            'city'    => $customer->city->name,
            'area'    => $customer->area->name,
            'address' => $customer->address,
        ];

        $this->billing_address = [
            'name'    => $customer->name,
            'phone'   => $customer->phone,
            'email'   => $customer->email,
            'region'  => $customer->region->name,
            'city'    => $customer->city->name,
            'area'    => $customer->area->name,
            'address' => $customer->address,
        ];
    }

    public function afterUpdate()
    {
        /**
         * Which order status revert the stock again
         */
        if($this->status_id == Settings::get('inventory_revert_deduction'))
        {
            StockDeduction::where('order_id', $this->id)->delete();
        }

        
        if(Settings::get('enable_purchase_restriction'))
        {
            if($this->status_id == Settings::get('inventory_deduction'))
            {
                foreach($this->items()->get() as $item)
                {
                    $stock_deduction = StockDeduction::where('order_id', $item->order_id)
                                                        ->where('product_id', $item->product_id)->get()->first();
                                   
                    if($stock_deduction)
                    {
                        $stock_deduction->sale_price = $item->price;
                        $stock_deduction->quantity = $item->quantity;
                        $stock_deduction->save();
                    }
                    else
                    {
                        $stock_deduction = new StockDeduction();
                        $stock_deduction->order_id = $item->order_id;
                        $stock_deduction->product_id = $item->product_id;
                        $stock_deduction->sale_price = $item->price;
                        $stock_deduction->quantity = $item->quantity;
                        $stock_deduction->save();
                    }
                }
            }
        }
    }

    /**
     * Generate new order number
     */
    protected function generateOrderNumber()
    {
        $obDate = Argon::today()->startOfDay();
        $bAvailableNumber  = false;
        $iTodayOrdersCount = $this->where('created_at', '>=', $obDate->toDateTimeString())->count() + 1;

        do {
            while (strlen($iTodayOrdersCount) < 4) 
            {
                $iTodayOrdersCount = '0'.$iTodayOrdersCount;
            }

            $this->order_number = Argon::today()->format('ymd').'-'.$iTodayOrdersCount;
            if (empty($this->where('order_number', $this->order_number)->first())) 
            {
                $bAvailableNumber = true;
            } 
            else 
            {
                $iTodayOrdersCount++;
            }
        } while (!$bAvailableNumber);

        $this->secret_key = $this->generateSecretKey();
    }

    public static function getList($limit, $page)
    {
        $user = Auth::getUser();

        if($user)
        {
            return self::where('user_id', $user->id)->orderBy('id', 'desc')->paginate($limit, $page);
        }
        
        return [];
    }

    public static function submissionCount()
    {
        $total = [];

        $initial_order_status = Settings::get('initial_order_status');

        $start_of_day = Carbon::today()->startOfDay();

        $total[] = self::where('status_id', $initial_order_status)->count();
        $total[] = self::where('has_remainder', 1)->whereDate('remainder_date', '<=', $start_of_day)->count();

        return array_sum($total);
    }

    public function scopeOwnList($query)
    {
        $user = BackendAuth::getUser();
        return $query->where('created_by', $user->id);
    }
}
