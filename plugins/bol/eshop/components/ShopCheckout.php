<?php namespace Bol\Eshop\Components;

use DB;
use Event;
use Auth;
use BackendAuth;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Bol\Eshop\Models\Product as EshopProduct;
use Bol\Eshop\Models\Cart;
use Bol\Eshop\Models\Order;
use Bol\Eshop\Models\OrderItem;
use Bol\Eshop\Models\Settings;
use Bol\Eshop\Models\PaymentMethod;
use Bol\Eshop\Models\Region;
use Bol\Eshop\Models\City;
use Bol\Eshop\Models\Area;
use RainLab\User\Models\User;
use Validator, ValidationException;
use Lang;
use Flash;
use Redirect;

class ShopCheckout extends ComponentBase
{
    /**
     * @var Bol\Eshop\Models\ShopCheckout to implement checkout logic to frontend.
     */


    public function componentDetails()
    {
        return [
            'name'        => 'bol.eshop::lang.settings.cart_title',
            'description' => 'bol.eshop::lang.settings.cart_description'
        ];
    }

    public function defineProperties()
    {
        return [];
    }


    public function onRun()
    {
        $this->prepareVars();
    }

    public function prepareVars()
    {
        $this->page['can_use_different_billing_address'] = Settings::get('can_use_different_billing_address');
        $this->page['can_guest_order'] = Settings::get('guest_order');
        $this->page['payment_methods'] = PaymentMethod::where('is_active', 1)->get();
        $this->page['cart'] = Cart::data();
    }

    public function onRender()
    {
        
    }  

    public function onPlaceOrder()
    {
        $data = post();

        // dd($data);

        $rules = [
            'delivery_address.name' => 'required',
            'delivery_address.phone' => 'required',
            // 'delivery_address.email' => 'required',
            // 'delivery_address.region' => 'required',
            // 'delivery_address.city' => 'required',
            // 'delivery_address.area' => 'required',
            'delivery_address.address' => 'required',
            'payment_method' => 'required',
            'terms' => 'required',
        ];

        $billing_address = [];
    
        if(post('check_billing'))
        {
            $rules['billing_address.name'] = 'required';
            $rules['billing_address.phone'] = 'required';
            // $rules['billing_address.email'] = 'required';
            // $rules['billing_address.region'] = 'required';
            // $rules['billing_address.city'] = 'required';
            // $rules['billing_address.area'] = 'required';
            $rules['billing_address.address'] = 'required';
        }
    
        $messages = [
            'delivery_address.name.required' => 'Please give full name for delivery address',
            'delivery_address.phone.required' => 'Please give phone number for delivery address',
            'delivery_address.email.required' => 'Please give your email address',
            'delivery_address.region.required' => 'Please select your region',
            'delivery_address.city.required' => 'Please select your city',
            'delivery_address.area.required' => 'Please select your area',
            'delivery_address.address.required' => 'Please give your details delivery address',
            'billing_address.name.required' => 'Please give full name for billing address',
            'billing_address.phone.required' => 'Please give phone number for billing address',
            'billing_address.email.required' => 'Please give your email address for billing',
            'billing_address.address.required' => 'Please give your details billing address',
            'payment_method.required' => 'Please select payment method.',
            // 'terms.required' => 'Please select checkbox to accept terms & condition',
        ];

        $cart = Cart::data();

        if(!$cart->shipping)
        {
            $rules['shipping_method_id'] = 'required';
            $messages['shipping_method_id.required'] = 'Please select shipping method.';
        }


    
        $validation = Validator::make($data, $rules, $messages);
    
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        if(post('billing_address'))
        {
            $billing_address = post('billing_address');
        }

        $user = Auth::getUser();  

        User::where('id', $user->id)->update([
            'name' => $data['delivery_address']['name'],
            // 'region_id' => $data['delivery_address']['region'],
            // 'city_id' => $data['delivery_address']['city'],
            // 'area_id' => $data['delivery_address']['area'],
            'address' => $data['delivery_address']['address'],
        ]);

        // $data['delivery_address']['region'] = Region::find($data['delivery_address']['region'])->name;
        // $data['delivery_address']['city'] = City::find($data['delivery_address']['city'])->name;
        // $data['delivery_address']['area'] = Area::find($data['delivery_address']['area'])->name;
    
        
    
        $order = new Order();
        $order->user_id = $user ? $user->id : null;
        $order->customer_name = $data['delivery_address']['name'];
        $order->phone = $data['delivery_address']['phone'];
        $order->delivery_address = $data['delivery_address'];
        $order->billing_address = $billing_address;
        $order->payment_method_id = $data['payment_method'];
        $order->shipping_method_id = $cart->shipping ? $cart->shipping_method_id : $data['shipping_method_id'];
        $order->tax_percent = Settings::get('tax_percentage') ? : 0;
        $order->status_id = Settings::get('initial_order_status');
        $order->other_deduction = NULL;
        $order->coupon_id = NULL;
        $order->payment_status = 0;
        $order->remarks = $data['remarks'];
        $order->save();
    
        DB::transaction(function() use ($order, $cart) {

            $order->save();

            foreach($cart->items()->get() as $item)
            {
                $order_item               = new OrderItem();
                $order_item->order_id     = $order->id;
                $order_item->product_id   = $item->product_id;
                $order_item->title        = $item->product->title;
                $order_item->quantity     = $item->quantity;
                $order_item->unit         = $item->product->unit->name;
                $order_item->color        = $item->color;
                $order_item->size         = $item->size;
                $order_item->price        = $item->price;
                $order_item->actual_price = $item->product->price;
                $order_item->save();
            }
        
            Cart::clearCart();
        });
        
            
        return Redirect::to('order-success');

    }
    
}
