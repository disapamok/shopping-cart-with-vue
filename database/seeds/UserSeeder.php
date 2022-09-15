<?php

use App\Models\Roles;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id' => Roles::ADMIN,
            'name' => 'The Administrator',
            'email' => 'admin@abc.com',
            'password' => Hash::make('12345678')
        ]);

        User::create([
            'role_id' => Roles::SALES_MANAGER,
            'name' => 'The Sales Manager',
            'email' => 'sales@abc.com',
            'password' => Hash::make('12345678')
        ]);

        User::create([
            'role_id' => Roles::OPERATION_MANAGER,
            'name' => 'The Operation Manager',
            'email' => 'operations@abc.com',
            'password' => Hash::make('12345678')
        ]);

        User::create([
            'role_id' => Roles::CUSTOMER,
            'name' => 'ABC Customer',
            'email' => 'customer@abc.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
