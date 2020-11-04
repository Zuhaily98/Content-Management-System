<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'zuhaily98@gmail.com')->first(); //first() when we want just one unique email

        if (!$user){
            User::create([
                'name' => 'Zuhaily Ramzi',
                'email' => 'zuhaily98@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('980710035619')
            ]);
        }
    }
}
