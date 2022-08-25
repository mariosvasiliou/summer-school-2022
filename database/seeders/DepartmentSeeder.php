<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //create initial departments
        Department::forceCreate([
            'name'        => 'IT',
            'description' => 'IT related department',
            'is_active'   => 1,
        ]);
        Department::forceCreate([
            'name'        => 'Sales',
            'description' => 'Sales related department',
            'is_active'   => 1,
        ]);
        Department::forceCreate([
            'name'        => 'Marketing',
            'description' => 'Marketing related department',
            'is_active'   => 1,
        ]);
        Department::forceCreate([
            'name'        => 'HR',
            'description' => 'Human resources related department',
            'is_active'   => 1,
        ]);
    }
}
