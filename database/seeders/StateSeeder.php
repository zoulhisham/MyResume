<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(State::count() == 0) {
            $country = Country::where('code', 'MY')->first();
            if($country){
                DB::table('states')->insert([
                    ['name' => 'Johor', 'country_id' => $country->id, 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Kedah', 'country_id' => $country->id, 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Kelantan', 'country_id' => $country->id, 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Melaka', 'country_id' => $country->id, 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Negeri Sembilan', 'country_id' => $country->id, 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Pahang', 'country_id' => $country->id, 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Pulau Pinang', 'country_id' => $country->id, 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Perak', 'country_id' => $country->id, 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Perlis', 'country_id' => $country->id, 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Selangor', 'country_id' => $country->id, 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Terengganu', 'country_id' => $country->id, 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Sabah', 'country_id' => $country->id, 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Sarawak', 'country_id' => $country->id, 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Wilayah Persekutuan (Kuala Lumpur)', 'country_id' => $country->id, 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Wilayah Persekutuan (Labuan)', 'country_id' => $country->id, 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Wilayah Persekutuan (Putrajaya)', 'country_id' => $country->id, 'created_at' => now(), 'updated_at' => now()],
                ]);
            }
        }
    }
}
