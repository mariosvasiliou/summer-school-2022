<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FakeDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->info('Seeding Fake Users');
        $this->call(FakeUserSeeder::class);
        $this->command->info('Seeding Fake Contacts');
        $this->call(FakeContactSeeder::class);
        $this->command->info('Seeding Fake Departments');
        $this->call(FakeDepartmentSeeder::class);
        $this->command->info('Seeding Fake Reports');
        $this->call(FakeReportSeeder::class);
    }
}
