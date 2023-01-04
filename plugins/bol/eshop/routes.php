<?php
use Bol\Eshop\Models\Region;
use Bol\Eshop\Models\City;
use Bol\Eshop\Models\Area;
use Bol\Eshop\Models\Customer;
use Bol\Eshop\Models\Order;

Route::get('sitemap.xml', function()
{
    return response(file_get_contents(resource_path('sitemap.xml')), 200, [
        'Content-Type' => 'application/xml'
    ]);
});


Route::get('robots.txt', function()
{
    return response(file_get_contents(resource_path('robots.txt')), 200, [
         'Content-Type' => 'text/plain'
    ]);
});

Route::get('regions', function()
{
    $json = file_get_contents('https://member.daraz.com.bd/locationtree/api/getSubAddressList?countryCode=BD');
    $regions = json_decode($json);

    foreach($regions->module as $region)
    {
        sleep(1);
        $json = file_get_contents('https://member.daraz.com.bd/locationtree/api/getSubAddressList?countryCode=BD&addressId='.$region->id);
        $cities = json_decode($json);
        echo $region->name.'<br>';

        $data_region = new Region();
        $data_region->name = $region->name;
        $data_region->code = $region->id;
        $data_region->save();

        foreach($cities->module as $city)
        {
            sleep(1);
            $json = file_get_contents('https://member.daraz.com.bd/locationtree/api/getSubAddressList?countryCode=BD&addressId='.$city->id);
            $areas = json_decode($json);
            echo ' - '.$city->name.'<br>';

            $data_city = new City();
            $data_city->region_id = $data_region->id;
            $data_city->name = $city->name;
            $data_city->save();

            if(isset($areas->module))
            {
                foreach($areas->module as $area)
                {
                    echo ' --- '.$area->name.'<br>';

                    $data_area = new area();
                    $data_area->city_id = $data_city->id;
                    $data_area->name = $area->name;
                    $data_area->save();
                }
            }
        }
    }
    // dd($obj->module);
});

Route::get('clear-data', function () {

    \Artisan::call('inventory:clearsystem');

    dd("All is cleared");

});

Route::get('update-data', function () {

    $order = Order::where('user_id', '!=', 0)->get();

    foreach($order as $item)
    {
        $area = Area::where('name', $item->delivery_address['area'])->get()->first();

        Customer::where('id', $item->user_id)->update([
            "phone" => $item->phone,
            "region_id" => $area ? $area->city->region_id : null,
            "city_id" => $area ? $area->city_id : null,
            "area_id" => $area ? $area->id : null,
            "address" => $item->delivery_address['address'],
        ]);
    }
    

    dd("All Updated");

});

?>