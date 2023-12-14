<?php

namespace Database\Seeders;

use App\Models\PaymentGateways;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentGateways::create([
            'name'=> "Cash on Delivery",
            'code'=> "COD"
        ]);

        PaymentGateways::create([
            'name'=> "Khalti",
            'code'=> "khalti"
        ]);
    }
}
