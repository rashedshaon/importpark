<?php namespace Bol\Eshop\Updates;

use Seeder;
use Bol\Eshop\Models\ItemStatus;

class SeedTableBolEshopItemStatuses extends Seeder
{
    public function run()
    {
        $data = [
            ["name" => "In Stock", "code" => "in-stock", "color" => "#7f8c8d"],
            ["name" => "Sold", "code" => "sold", "color" => "#2980b9"],
            ["name" => "Need to Service", "code" => "need-to-service", "color" => "#27ae60"],
        ];

        ItemStatus::truncate();
        ItemStatus::insert($data);
    }
}