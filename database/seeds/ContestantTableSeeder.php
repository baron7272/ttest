<?php

use Illuminate\Database\Seeder;

class ContestantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Contestant::class, 100)->create();
    }
}
