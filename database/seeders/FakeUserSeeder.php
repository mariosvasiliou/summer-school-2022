<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FakeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //create 500 fake users
        User::factory()->count(500)->createQuietly();
        //create 500 fake unverified users
        User::factory()->count(500)->unverified()->createQuietly();
        //create 500 fake admin verified users
        User::factory()->count(500)->admin()->createQuietly();
        //create 500 fake admin unverified users
        User::factory()->count(500)->admin()->unverified()->createQuietly();
    }
}
