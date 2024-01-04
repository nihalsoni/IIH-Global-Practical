<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $states = [
            'Gujarat',
            'Maharashtra',
            'Rajasthan',
            'Uttar Pradesh',
            'Karnataka',
            // Add more states as needed
        ];

        foreach ($states as $state) {
            DB::table('states')->insert([
                'name' => $state,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $cities = [
            // Cities for Gujarat
            ['state_id' => 1, 'name' => 'Ahmedabad'],
            ['state_id' => 1, 'name' => 'Vadodara'],
            ['state_id' => 1, 'name' => 'Surat'],

            // Cities for Maharashtra
            ['state_id' => 2, 'name' => 'Mumbai'],
            ['state_id' => 2, 'name' => 'Pune'],
            ['state_id' => 2, 'name' => 'Nagpur'],

            // Cities for Rajasthan
            ['state_id' => 3, 'name' => 'Jaipur'],
            ['state_id' => 3, 'name' => 'Jodhpur'],
            ['state_id' => 3, 'name' => 'Udaipur'],

            // Cities for Uttar Pradesh
            ['state_id' => 4, 'name' => 'Lucknow'],
            ['state_id' => 4, 'name' => 'Kanpur'],
            ['state_id' => 4, 'name' => 'Varanasi'],

            // Cities for Karnataka
            ['state_id' => 5, 'name' => 'Bangalore'],
            ['state_id' => 5, 'name' => 'Mysore'],
            ['state_id' => 5, 'name' => 'Hubli'],
        ];

        foreach ($cities as $city) {
            DB::table('cities')->insert([
                'state_id' => $city['state_id'],
                'name' => $city['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
