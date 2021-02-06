<?php
use App\NextOfKin;
use Illuminate\Database\Seeder;

class NextOfKinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nextOfKin = file_get_contents(storage_path() . '/json/nextOfKin.json');
        $nextOfKin = json_decode($nextOfKin);
        foreach ($nextOfKin as $next) {
            NextOfKin::create([
                'name' => $next->name,
            ]);
        }
    }
}
