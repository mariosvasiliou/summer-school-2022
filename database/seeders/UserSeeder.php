<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //create initial admin user
        $contact = Contact::forceCreate([
            'first_name' => 'Admin',
            'last_name'  => 'User',
            'email'      => 'admin@example.com',
            'is_user'    => 1,
        ]);
        User::forceCreate([
            'email'             => 'admin@example.com',
            'email_verified_at' => now(),
            'contact_id'        => $contact->id,
            'is_admin'          => 1,
        ]);
        //create initial normal user
        $contact = Contact::forceCreate([
            'first_name' => 'Normal',
            'last_name'  => 'User',
            'email'      => 'user@example.com',
            'is_user'    => 1,
        ]);
        User::forceCreate([
            'email'             => 'user@example.com',
            'email_verified_at' => now(),
            'contact_id'        => $contact->id,
            'is_admin'          => 1,
        ]);
    }
}
