<?php namespace Bol\Eshop\Components;

use Event;
use BackendAuth;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Bol\Eshop\Models\Product as EshopProduct;
use Bol\Eshop\Models\Cart;
use Bol\Eshop\Models\ShippingMethod;
use Lang;
use Flash, ValidationException;
use Redirect;

class ShoppingCart extends ComponentBase
{
    /**
     * @var Bol\Eshop\Models\Cart The cart model used for display.
     */
    public $cart;
    public $cart_count;


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
        $this->refresh();
    }

    public function onRender()
    {
        $this->refresh();
    }

    public function onAddToCart()
    {
        $post = post();

        if(!isset($post['color']))
        {
            $post['color'] = '';
        }

        if(!isset($post['size']))
        {
            $post['size'] = '';
        }

        // dd($post);

        Cart::addToCart($post['product_id'], $post['quantity'], $post['color'], $post['size']);

        $this->refresh();

        Flash::success(Lang::get('bol.eshop::lang.cart.successfully_added_to_cart'));

        return ['.cartcount' => $this->renderPartial('@cart-count'), '.minicart' => $this->renderPartial('@mini-cart')];
    }

    public function onBuyNow()
    {
        $post = post();

        if(!isset($post['color']))
        {
            $post['color'] = '';
        }

        if(!isset($post['size']))
        {
            $post['size'] = '';
        }

        Cart::addToCart($post['product_id'], $post['quantity'], $post['color'], $post['size']);

        return Redirect::to('cart');
    }

    public function onUpdateCartItem()
    {
        $post = post();

        Cart::updateCartItem($post['item_id'], $post['quantity']);

        $this->refresh();

        Flash::success(Lang::get('bol.eshop::lang.cart.item_quantity_successfully_updated'));

        return  [
                    '.cartcount' => $this->renderPartial('@cart-count'), 
                    '.minicart' => $this->renderPartial('@mini-cart'),
                    '.cart_items' => $this->renderPartial('@cart-items'),
                    '.cart_summary' => $this->renderPartial('@cart-summary'),
                ];
    }

    public function onRemoveCartItem()
    {
        $post = post();

        Cart::removeCartItem($post['item_id']);

        $this->refresh();

        Flash::error(Lang::get('bol.eshop::lang.cart.item_removed_from_cart'));

        return  [
                    '.cartcount' => $this->renderPartial('@cart-count'), 
                    '.minicart' => $this->renderPartial('@mini-cart'),
                    '.cart_items' => $this->renderPartial('@cart-items'),
                    '.cart_summary' => $this->renderPartial('@cart-summary'),
                ];
    }

    public function onCheckout()
    {
        $post = post();

        // dd($post);
        // if(!isset($post['shipping_method_id']))
        // {
        //     throw new ValidationException(['error' => 'Please select shipping method.']);
        // }

        // $cart = Cart::data();
        // $cart->shipping_method_id = $post['shipping_method_id'];
        // $cart->save();

        return Redirect::to('checkout');
    }

    public function refresh()
    {
        $this->page['shipping_methods'] = ShippingMethod::where('is_active', 1)->get();
        $this->cart = $this->page['cart'] = Cart::data();
        $this->cart_count = $this->page['cart_count'] = Cart::count();
    }
}
