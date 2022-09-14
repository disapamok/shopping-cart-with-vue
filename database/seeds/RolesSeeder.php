<?php

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Roles::create(['name' => 'Admin']);
        Roles::create(['name' => 'Sales Manager']);
        Roles::create(['name' => 'Operation Manager']);
        Roles::create(['name' => 'Customer']);
    }
}
