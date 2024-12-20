<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'username' => 'admin',
            'position' => 'nstpdirector',
            'password' => Hash::make('taler113099'),
        ]);
        $admin->assignRole('admin');


        $s1Admin = User::create([
            'name' => 'tests1admin',
            'username' => 'tests1admin',
            'position' => 's1-admin',
            'password' => Hash::make('taler113099')
        ]);
        $s1Admin->assignRole('s1-admin');
    }
}
