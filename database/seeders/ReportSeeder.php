<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Reports\ClientReport;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //create initial reports
        Report::forceCreate([
            'name'        => 'Clients Report',
            'description' => 'Show all contacts that are clients.blade.php',
            'class_name'  => ClientReport::class,
            'is_active'   => 1,
        ]);
    }
}
