<?php

use App\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = file_get_contents(storage_path() . '/json/banks.json');
        $banks = json_decode($banks);
        foreach ($banks as $bank) {
            Bank::create([
                'name' => $bank->name,
                'code' => $bank->code,
            ]);
        }
    }
}
