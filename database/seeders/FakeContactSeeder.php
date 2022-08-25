<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class FakeContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //create 5000 fake physical contacts
        Contact::factory()->count(5000)->createQuietly();
        //create 5000 fake legal contacts
        Contact::factory()->count(5000)->legal()->createQuietly();
    }
}
