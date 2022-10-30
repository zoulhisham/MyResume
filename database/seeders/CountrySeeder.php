<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Country::count() == 0) {
            DB::table('countries')->insert([
                ['name' => 'Malaysia', 'code' => 'MY', 'created_at' => now(), 'updated_at' => now()]
            ]);
        }
    }
}
