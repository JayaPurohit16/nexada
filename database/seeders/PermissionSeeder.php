<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $module = Module::where('module_name','role')->first();
        if(!$module){
            $module = Module::create(['module_name' => 'role']);
            $permissions = [
                'role-list',
                'role-create',
                'role-edit',
                'role-delete',
            ];
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission, 'module_id' => $module->id]);
            }
        }
        $module_1 = Module::where('module_name','terms_and_conditions')->first();
        if(!$module_1){
            $module_1 = Module::create(['module_name' => 'terms_and_conditions']);
            $permissions = [
                'terms_and_conditions-list',
                'terms_and_conditions-create',
                'terms_and_conditions-edit',
                'terms_and_conditions-delete',
            ];
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission, 'module_id' => $module_1->id]);
            }
        }
        
        $module_2 = Module::where('module_name','privacy_and_policy')->first();
        if(!$module_2){
            $module_2 = Module::create(['module_name' => 'privacy_and_policy']);
            $permissions = [
                'privacy_and_policy-list',
                'privacy_and_policy-create',
                'privacy_and_policy-edit',
                'privacy_and_policy-delete',
            ];
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission, 'module_id' => $module_2->id]);
            }
        }
        $module_3 = Module::where('module_name','cms_setting')->first();
        if(!$module_3){
            $module_3 = Module::create(['module_name' => 'cms_setting']);
            $permissions = [
                'cms_setting-list',
                'cms_setting-create',
                'cms_setting-edit',
                'cms_setting-delete',
            ];
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission, 'module_id' => $module_3->id]);
            } 
        }

        $module_4 = Module::where('module_name','location')->first();
        if(!$module_4){
            $module_4 = Module::create(['module_name' => 'location']);
            $permissions = [
                'location-list',
                'location-create',
                'location-edit',
                'location-delete',
            ];
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission, 'module_id' => $module_4->id]);
            } 
        }

        $module_5 = Module::where('module_name','subscription')->first();
        if(!$module_5){
            $module_5 = Module::create(['module_name' => 'subscription']);
            $permissions = [
                'subscription-list',
                'subscription-create',
                'subscription-edit',
                'subscription-delete',
            ];
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission, 'module_id' => $module_5->id]);
            } 
        }

        $module_6 = Module::where('module_name','teacher')->first();
        if(!$module_6){
            $module_6 = Module::create(['module_name' => 'teacher']);
            $permissions = [
                'teacher-list',
                'teacher-create',
                'teacher-edit',
                'teacher-delete',
            ];
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission, 'module_id' => $module_6->id]);
            } 
        }

        $module_7 = Module::where('module_name','student')->first();
        if(!$module_7){
            $module_7 = Module::create(['module_name' => 'student']);
            $permissions = [
                'student-list',
                'student-create',
                'student-edit',
                'student-delete',
            ];
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission, 'module_id' => $module_7->id]);
            } 
        }

        $module_8 = Module::where('module_name','instrument')->first();
        if(!$module_8){
            $module_8 = Module::create(['module_name' => 'instrument']);
            $permissions = [
                'instrument-list',
                'instrument-create',
                'instrument-edit',
                'instrument-delete',
            ];
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission, 'module_id' => $module_8->id]);
            } 
        }

        $module_9 = Module::where('module_name','skill')->first();
        if(!$module_9){
            $module_9 = Module::create(['module_name' => 'skill']);
            $permissions = [
                'skill-list',
                'skill-create',
                'skill-edit',
                'skill-delete',
            ];
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission, 'module_id' => $module_9->id]);
            } 
        }

        $module_10 = Module::where('module_name','admin')->first();
        if(!$module_10){
            $module_10 = Module::create(['module_name' => 'admin']);
            $permissions = [
                'admin-list',
                'admin-create',
                'admin-edit',
                'admin-delete',
            ];
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission, 'module_id' => $module_10->id]);
            } 
        }
    }
}
