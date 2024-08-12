<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email','admin@gmail.com')->first();
        if(!$user){
            $user = User::create([
                'first_name' => 'Super',
                'second_name' => 'Admin',
                'email' => 'admin@gmail.com',
                'phone' => '9876543210',
                'password' => Hash::make('12345678')
            ]);
    
            $role = Role::where('name','Super Admin')->first();
            if($role){
                $user->assignRole($role->name);
            }
        }
    }
}
