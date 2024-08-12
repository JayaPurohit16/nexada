<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name','Super Admin')->first();
        if(!$role){
            $role = Role::create(['name' => 'Super Admin']);
            $permissions = Permission::pluck('id','id')->all();
            $role->syncPermissions($permissions);
        }

        $role = Role::where('name','Admin')->first();
        if(!$role){
            $role = Role::create(['name' => 'Admin']);
            $permissions = Permission::pluck('id','id')->all();
            $role->syncPermissions($permissions);
        }

        $role = Role::where('name','Desk')->first();
        if(!$role){
            $role = Role::create(['name' => 'Desk']);
            $permissions = Permission::pluck('id','id')->all();
            $role->syncPermissions($permissions);
        }

        $role = Role::where('name','Teacher')->first();
        if(!$role){
            $role = Role::create(['name' => 'Teacher']);
            $permissions = Permission::pluck('id','id')->all();
            $role->syncPermissions($permissions);
        }

        $role = Role::where('name','Student')->first();
        if(!$role){
            $role = Role::create(['name' => 'Student']);
            $permissions = Permission::pluck('id','id')->all();
            $role->syncPermissions($permissions);
        }

        $role = Role::where('name','Parent')->first();
        if(!$role){
            $role = Role::create(['name' => 'Parent']);
            $permissions = Permission::pluck('id','id')->all();
            $role->syncPermissions($permissions);
        }
    }
}
