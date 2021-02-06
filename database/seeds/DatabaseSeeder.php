<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call([UsersTableSeeder::class]);
        // $this->call([BankSeeder::class]);
        // $this->call([CountrySeeder::class]);
        
        // $this->call([NextOfKinSeeder::class]);
        $this->call([UserTableSeeder::class]);
        $this->call([ContestantTableSeeder::class]);
        $this->call([CommentTableSeeder::class]);
        $this->call([UploadTableSeeder::class]);
        $this->call([WalletTableSeeder::class]);
        $this->call([NotificationTableSeeder::class]);
        $this->call([FanTableSeeder::class]);
    }
}
