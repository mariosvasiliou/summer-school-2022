<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->info('Seeding Users');
        $this->call(UserSeeder::class);
        $this->command->info('Seeding Departments');
        $this->call(DepartmentSeeder::class);
        $this->command->info('Seeding Reports');
        $this->call(ReportSeeder::class);
    }
}
