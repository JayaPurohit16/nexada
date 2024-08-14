<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role-list', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        try {
            $roles = Role::all();
            return view('admin.roles.index',compact('roles'));
        } catch (Exception $e) {
            Log::info('admin Roles index Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function create()
    {
        try {
            $modules = Module::with('permissions')->get();
            foreach ($modules as $module) {
                $module->formatted_name = ucfirst(strtolower(str_replace('_', ' ', $module->module_name)));
            }
            return view('admin.roles.create',compact('modules'));
        } catch (Exception $e) {
            Log::info('admin Roles index Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $role = Role::where('name',$request->role)->first();
            if($role){
                return redirect()->back()->with('error','Role already exists'); 
            } else {
                $role = new Role();
                $role->name = isset($request->role) ? $request->role : '';
                $role->save(); 
                $role->syncPermissions($request->permission);
                DB::commit();
                return redirect()->route('admin.roles.index')->with('success','Role created sucessfully'); 
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('admin Roles store Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }


    public function edit($id)
    {
        try {
            $role = Role::where('id',$id)->first();
            if($role){
                $modules = Module::with('permissions')->get();
                foreach ($modules as $module) {
                    $module->formatted_name = ucfirst(strtolower(str_replace('_', ' ', $module->module_name)));
                }
                $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
                    ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                    ->all();
                return view('admin.roles.edit',compact('role','modules','rolePermissions'));
            } else {
                return redirect()->back()->with('error','Role not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin Roles index Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $role = Role::where('id',$request->id)->first();
            if($role){
                $existingRole = Role::where('name', $request->role)->where('id', '!=', $role->id)->first();
                if ($existingRole) {
                return redirect()->back()->with('error', 'Role name already exists');
                }
                $role->name = isset($request->role) ? $request->role : '';
                $role->update(); 
                $role->syncPermissions($request->permission);
                DB::commit();
            } else {
                return redirect()->back()->with('error','Role not found'); 
            }
            return redirect()->route('admin.roles.index')->with('success','Role updated sucessfully'); 
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('admin Roles update Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::where('id',$id)->first();
            if($role){
                $role->delete();
                return redirect()->route('admin.roles.index')->with('success','Role deleted sucessfully'); 
            } else {
                return redirect()->back()->with('error','Role not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin Roles destroy Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function getRoles(Request $request)
    {
      
        // Page Length
        $pageNumber = ($request->start / $request->length )+1;
        $pageLength = $request->length;
        $skip       = ($pageNumber-1) * $pageLength;

        // Page Order
        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        // $query = Role::query();
        $query = Role::where('name','!=','Super Admin');
        // Search
        $search = $request->search;
        $query = $query->where(function($query) use ($search){
            $query->orWhere('name', 'like', "%".$search."%");
            // $query->orWhere('description', 'like', "%".$search."%");
            // $query->orWhere('amount', 'like', "%".$search."%");
        });

        $orderByName = 'id';
        switch($orderColumnIndex){
            case '0':
                $orderByName = 'id';
                break;
            case '1':
                $orderByName = 'name';
                break;
            // case '2':
            //     $orderByName = 'amount';
            //     break;
        
        }
        $query = $query->orderBy($orderByName, $orderBy);
        $recordsFiltered = $recordsTotal = $query->count();
        $subscription = $query->skip($skip)->take($pageLength)->get();

        return response()->json(["draw"=> $request->draw, "recordsTotal"=> $recordsTotal, "recordsFiltered" => $recordsFiltered, 'data' => $subscription], 200);
    }
}
