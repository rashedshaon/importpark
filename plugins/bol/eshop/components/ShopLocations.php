<?php namespace Bol\Eshop\Components;

use Cms\Classes\ComponentBase;
use Bol\Eshop\Models\Region;
use Bol\Eshop\Models\City;
use Bol\Eshop\Models\Area;

class ShopLocations extends ComponentBase
{

    public function componentDetails()
    {
        return [];
    }

    public function defineProperties()
    {
        return [];
    }


    public function onRun()
    {
        $this->page['regions'] = Region::get();
    }   

    public function onChangeRegion()
    {
        $post = post();

        $this->page['items'] = Region::where('name', $post['name'])->get()->first()->cities()->get();

        return  [
                    '#cities' => $this->renderPartial('@cities'),
                ];
    }

    public function onChangeCity()
    {
        $post = post();

        $this->page['items'] = City::where('name', $post['name'])->get()->first()->areas()->get();

        return  [
                    '#areas' => $this->renderPartial('@areas'),
                ];
    }
}