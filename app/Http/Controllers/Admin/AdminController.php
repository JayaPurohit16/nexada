<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendPasswordEmail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin-list', ['only' => ['index']]);
        $this->middleware('permission:admin-create', ['only' => ['create','store']]);
        $this->middleware('permission:admin-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        try {
            $admins = User::whereHas('roles', function ($q) {
                    $q->where('name', 'Admin');
                })->select('users.*')->get();
            return view('admin.admin.index',compact('admins'));
        } catch (Exception $e) {
            Log::info('admin admin index Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');      
        }
    }

    public function create()
    {
        try {
            return view('admin.admin.create');
        } catch (Exception $e) {
            Log::info('admin admin create Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');      
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'      => 'required',
            'second_name'     => 'required',
            'phone'           => 'required|numeric',
            'email' => 'required|email|unique:users,email',
        ]);
        try {
            DB::beginTransaction();
            $user = new User();
            $user->first_name = isset($request->first_name) ? $request->first_name : '';
            $user->second_name = isset($request->second_name) ? $request->second_name : '';
            $user->phone = isset($request->phone) ? $request->phone : '';
            $user->email = isset($request->email) ? $request->email : '';

            $randomUserPassword = Str::random(10);
            $user->password = Hash::make($randomUserPassword);

            $role = Role::where('name','Admin')->first();
            if($role){
                $user->assignRole($role->name);
            }
            $user->save();

            if($user){
                $data = [
                    'first_name'     => $user->first_name,
                    'second_name'     => $user->second_name,
                    'password' => $randomUserPassword,
                ];
                try {
                    Mail::to($user->email)->send(new SendPasswordEmail($data));
                } catch (Exception $mailException) {
                    DB::rollBack();
                    Log::error('Mail error: ' . $mailException->getMessage());
                    return redirect()->back()->with('error', 'Failed to send email. Please try again.   ');
                }
            }
            DB::commit();
            return redirect()->route('admin.admin.index')->with('success','Admin created sucessfully'); 
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('admin admin store Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function edit($id)
    {
        try {
            $admin = User::where('id',$id)->first();
            if($admin){
                return view('admin.admin.edit',compact('admin'));
            } else {
                return redirect()->back()->with('error','Admin not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin admin edit Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');   
        }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'first_name'      => 'required',
            'second_name'     => 'required',
            'phone'           => 'required|numeric',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($request->id),
            ],
        ]);
        try {
            $admin = User::where('id',$request->id)->first();
            if($admin){
                    $admin->first_name = isset($request->first_name) ? $request->first_name : '';
                    $admin->second_name = isset($request->second_name) ? $request->second_name : '';
                    $admin->phone = isset($request->phone) ? $request->phone : '';
                    $admin->email = isset($request->email) ? $request->email : '';

                    $admin->update();
                } else {
                    return redirect()->back()->with('error', 'Admin not found');
                }
            return redirect()->route('admin.admin.index')->with('success','Admin updated sucessfully'); 
        } catch (Exception $e) {
            Log::info('admin admin update Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function destroy($id)
    {
        try {
            $admin = User::where('id',$id)->first();
            if($admin){

                $originalEmailParts = explode('@', $admin->email);
                $baseEmail = $originalEmailParts[0];
                $domain = $originalEmailParts[1];
                
                $lastUser = User::onlyTrashed()
                    ->where('email', 'LIKE', "$baseEmail%")
                    ->orderBy('id', 'desc')
                    ->first();

                if ($lastUser) {
                    $lastEmailParts = explode('@', $lastUser->email);
                    $lastBaseEmail = explode('_backup', $lastEmailParts[0]);
                    $suffix = isset($lastBaseEmail[1]) ? (int)$lastBaseEmail[1] + 1 : 1;
                    $newEmail = "{$lastBaseEmail[0]}_backup{$suffix}@{$domain}";
                } else {
                    $newEmail = "{$baseEmail}_backup1@{$domain}";
                }
                
                $admin->email = $newEmail;
                $admin->save();

                $admin->delete();
                return redirect()->route('admin.admin.index')->with('success','Admin deleted sucessfully'); 
            } else {
                return redirect()->back()->with('error','Admin not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin admin destroy Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');    
        }
    }

    public function getAdmin(Request $request)
    {
      
        // Page Length
        $pageNumber = ($request->start / $request->length )+1;
        $pageLength = $request->length;
        $skip       = ($pageNumber-1) * $pageLength;

        // Page Order
        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        $query = User::whereHas('roles', function ($q) {
                $q->where('name', 'Admin');
            })->select('users.*');
        // Search
        $search = $request->search;
        $query = $query->where(function($query) use ($search){
            $query->orWhere('first_name', 'like', "%".$search."%");
            $query->orWhere('second_name', 'like', "%".$search."%");
            $query->orWhere('email', 'like', "%".$search."%");
            $query->orWhere('phone', 'like', "%".$search."%");
        });

        $orderByName = 'teachers.id';
        $orderByName = 'id';
        switch($orderColumnIndex){
            case '0':
                $orderByName = 'id';
                break;
            case '1':
                $orderByName = 'first_name';
                break;
            case '2':
                $orderByName = 'email';
                break;
            case '3':
                $orderByName = 'phone';
                break;      
        }
        $query = $query->orderBy($orderByName, $orderBy);
        $recordsFiltered = $recordsTotal = $query->count();
        $admins = $query->skip($skip)->take($pageLength)->get();
        return response()->json([
            "draw"=> $request->draw, 
            "recordsTotal"=> $recordsTotal, 
            "recordsFiltered" => $recordsFiltered, 
            "data" => $admins->map(function($admin) {
                return [
                    'id' => $admin->id,
                    'fullName' => $admin->fullName,
                    'email' => $admin->email,
                    'phone' => $admin->phone,
                ];
            }),
        ], 200);
    }

    public function checkMail(Request $request)
    {
        $email = $request->input('email');
        $currentUserId = $request->input('id');

        if(isset($currentUserId)){
            $exists = User::where('email', $email)->where('id', '!=', $currentUserId)->exists();
        } else {
            $exists = User::where('email', $email)->exists();
        }
        return response()->json(['exists' => $exists]);
    }
}
