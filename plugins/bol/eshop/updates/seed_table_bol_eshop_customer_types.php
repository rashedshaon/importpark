<?php namespace Bol\Eshop\Updates;

use Seeder;
use Bol\Eshop\Models\CustomerType;

class SeedTableBolEshopCustomerTypes extends Seeder
{
    public function run()
    {
        $data = [
            ["name" => "General Customer", "code" => "general-customer"],
            ["name" => "Supplier", "code" => "supplier"],
            ["name" => "Firm", "code" => "firm"],
            ["name" => "VIP Customer", "code" => "vip-customer"],
        ];

        CustomerType::truncate();
        CustomerType::insert($data);
    }
}