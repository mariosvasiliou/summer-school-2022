<?php

namespace Database\Seeders;

use App\Models\Report;
use Illuminate\Database\Seeder;

class FakeReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //create 1000 fake reports
        Report::factory()->count(1000)->createQuietly();
    }
}
