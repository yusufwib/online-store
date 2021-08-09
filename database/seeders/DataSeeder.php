<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'name' => 'Admin Pablo Escobar',
            'password' => bcrypt('password123'), //password123
            'role_id' => 2,
            'email' => 'admin-escobar@mail.com'
        ]);

        User::insert([
            'name' => 'CS Pablo Escobar',
            'password' => bcrypt('password123'), //password123
            'role_id' => 3,
            'email' => 'jury-escobar@mail.com'
        ]);

        Role::insert([
            'name' => 'Admin',
        ]);

        Role::insert([
            'name' => 'Owner',
        ]);

    }
}
