<?php

namespace Database\Seeders;

use App\Models\DeliveryAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = ['ул.Немига','ул.Немига 5','ул.Немига 10'];
        for ($i = 0; $i < count($arr); $i++) {
            DeliveryAddress::create([
                'address' => $arr[$i],
            ]);
        }
    }
}
