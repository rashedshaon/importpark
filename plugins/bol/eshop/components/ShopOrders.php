<?php namespace Bol\Eshop\Components;

use Cms\Classes\ComponentBase;
use Bol\Eshop\Models\Order;

class ShopOrders extends ComponentBase
{

    public $orders;


    public function componentDetails()
    {
        return [
            'name'        => 'bol.eshop::lang.order.title',
            'description' => 'bol.eshop::lang.order.description'
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

    protected function prepareVars()
    {
        $this->orders = $this->page['orders'] = Order::getList(10, 1);
        
        if($this->property('order_id'))
        {
            $this->page['order'] = Order::where('secret_key', $this->property('order_id'))->get()->first();
        }
    }
    

    public function onScrollList()
    {
        $page = post('page') ?? 1;

        $this->page['orders'] = Order::getList(10, $page);

        return [
            '@.list-items' => $this->renderPartial('@list-items')
        ];
    }
}