<?php namespace Bol\Eshop\Components;

use Cms\Classes\ComponentBase;
use Bol\Eshop\Models\Region;
use Bol\Eshop\Models\City;
use Bol\Eshop\Models\Area;
use RainLab\User\Models\User;
use Auth, Validator, ValidationException;

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
        $this->page['cities'] = City::get();
        $this->page['areas'] = Area::get();
    }
    
    public function onPhoneTrack()
    {
        $post = post();

        $rules = [
            'delivery_address.phone' => 'required|regex:/^[0-1]{2}[0-9]{9}$/',
        ];

        $messages = [
            'delivery_address.phone.required' => 'Please give a phone number',
            'delivery_address.phone.regex' => 'Please give a correct phone number',
        ];

        $validation = Validator::make($post, $rules, $messages);
    
        if ($validation->fails()) 
        {
            throw new ValidationException($validation);
        }

        $phone = $post['delivery_address']['phone'];

        $user = User::where('phone', $phone)->get()->first();

        if(!$user)
        {
            $user = new User();
            $user->rules = [];
            $user->phone = $phone;
            $user->password = '654644846';
            $user->password_confirmation = '654644846';
            $user->type_id = 1;
            $user->is_activated = 1;
            $user->save();
        }

        Auth::login($user, 1);

        $this->page['regions'] = Region::get();
        $this->page['user'] = $user;

        return  [
                    '#customer_details' => $this->renderPartial('@customer-details'),
                ];
    }

    public function onChangeRegion()
    {
        $post = post();

        $this->page['items'] = Region::find($post['name'])->cities()->get();

        return  [
                    '#cities' => $this->renderPartial('@cities'),
                ];
    }

    public function onChangeCity()
    {
        $post = post();

        $this->page['items'] = City::find($post['name'])->areas()->get();

        return  [
                    '#areas' => $this->renderPartial('@areas'),
                ];
    }
}