<?php namespace Bol\Eshop\Updates;

use Seeder;
use Bol\Eshop\Models\PurchaseStatus;

class SeedTableBolEshopPurchaseStatuses extends Seeder
{
    public function run()
    {
        $data = [
            ["name" => "Initiated", 'code' => 'initiated', "color" => "#7f8c8d"],
            ["name" => "In Shipment", 'code' => 'in-shipment', "color" => "#2980b9"],
            ["name" => "Received", 'code' => 'received', "color" => "#27ae60"],
        ];

        PurchaseStatus::truncate();
        PurchaseStatus::insert($data);
    }
}