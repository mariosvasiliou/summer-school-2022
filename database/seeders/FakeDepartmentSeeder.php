<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class FakeDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //create 1000 fake departments
        Department::factory()->count(1000)->createQuietly();
    }
}
