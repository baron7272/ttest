<?php

use Illuminate\Database\Seeder;

class FanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Fan::class, 100)->create();
    }
}
