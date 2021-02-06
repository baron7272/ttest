<?php

use App\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = file_get_contents(storage_path() . '/json/countries.json');
        $countries = json_decode($countries);
        foreach ($countries as $country) {
            Country::create([
                'name' => $country->name,
                'code' => $country->isoCode,
                'extension' => $country->phoneCode,
            ]);
        }
    }
}
