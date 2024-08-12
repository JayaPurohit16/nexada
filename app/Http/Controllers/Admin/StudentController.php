<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendPasswordEmail;
use App\Models\Instrument;
use App\Models\Location;
use App\Models\Student;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\User;
use App\Models\UserParent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:student-list', ['only' => ['index']]);
        $this->middleware('permission:student-create', ['only' => ['create','store']]);
        $this->middleware('permission:student-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:student-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        try {
            $students = Student::all();
            return view('admin.student.index',compact('students'));
        } catch (Exception $e) {
            Log::info('admin student index Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function create()
    {
        try {
            $locations = Location::get();
            $instruments = Instrument::get();
            $subscriptionTypes = SubscriptionType::get();
            return view('admin.student.create',compact('locations','instruments','subscriptionTypes'));
        } catch (Exception $e) {
            Log::info('admin student create Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'         => 'required',
            'second_name'        => 'required',
            'email'              => 'nullable|email|unique:users,email',
            'phone'              => 'nullable|numeric',
            'date_of_birth'      => 'required|date',
            'location_id'        => 'required',
            'primary_instrument' => 'required',
            'plan'               => 'required',

            'parent_first_name'  => $request->age < 18 ? 'required' : 'nullable',
            'parent_second_name' => $request->age < 18 ? 'required' : 'nullable',
            'parent_email'       => $request->age < 18 ? 'required|email' : 'nullable',
            'parent_phone'       => $request->age < 18 ? 'required|numeric' : 'nullable',
        ]);
        try {
            DB::beginTransaction();
                $user = new User();
                $user->first_name = isset($request->first_name) ? $request->first_name : '';
                $user->second_name = isset($request->second_name) ? $request->second_name : '';
                $user->email = isset($request->email) ? $request->email : '';
                $user->phone = isset($request->phone) ? $request->phone : '';

                $randomUserPassword = Str::random(10);
                $user->password = Hash::make($randomUserPassword);
                $role = Role::where('name','Student')->first();
                if($role){
                    $user->assignRole($role->name);
                }
                $user->save();
                if($user && $user->email != null){
                    $data = [
                        'name'     => $user->first_name,
                        'password' => $randomUserPassword,
                    ];
                    Mail::to($user->email)->send(new SendPasswordEmail($data));
                }

                $student = new Student();
                if(isset($request->age) && $request->age < 18){
                    $student->type = "0";
                } else {
                    $student->type = "1";
                }
                $student->user_id = $user->id;
                $student->date_of_birth = isset($request->date_of_birth) ? $request->date_of_birth : '';
                $student->location_id = isset($request->location_id) ? $request->location_id : '';
                $student->primary_instrument = isset($request->primary_instrument) ? $request->primary_instrument : '';
                $student->plan = isset($request->plan) ? $request->plan : '';

                $student->save();

                if(isset($request->age) && $request->age < 18){
                    $parentUser = new User();
                    $parentUser->first_name = isset($request->parent_first_name) ? $request->parent_first_name : '';
                    $parentUser->second_name = isset($request->parent_second_name) ? $request->parent_second_name : '';
                    $parentUser->email = isset($request->parent_email) ? $request->parent_email : '';
                    $parentUser->phone = isset($request->parent_phone) ? $request->parent_phone : '';

                    $randomParentPassword = Str::random(10);
                    $parentUser->password = Hash::make($randomParentPassword);
                    $role = Role::where('name','Parent')->first();
                    if($role){
                        $parentUser->assignRole($role->name);
                    }
                    $parentUser->save();

                    if($parentUser){
                        $data = [
                            'name'     => $parentUser->first_name,
                            'password' => $randomParentPassword,
                        ];
                        Mail::to($parentUser->email)->send(new SendPasswordEmail($data));
                    }

                    $parent = new UserParent();
                    $parent->user_id = $parentUser->id;
                    $parent->parent_of_student = $student->id;
                    $parent->save();
                } 

                DB::commit();
                return redirect()->route('admin.student.index')->with('success','Student created sucessfully'); 
            
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('admin student store Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function edit($id)
    {
        try {
            $student = Student::where('id',$id)->first();
            $locations = Location::get();
            $instruments = Instrument::get();
            $subscriptionTypes = SubscriptionType::get();
            if($student){
                return view('admin.student.edit',compact('student','locations','instruments','subscriptionTypes'));
            } else {
                return redirect()->back()->with('error','Student not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin student edit Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');   
        }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'first_name'         => 'required',
            'second_name'        => 'required',
            'email' => [
                'email',
                Rule::unique('users')->ignore($request->user_id),
            ],
            'phone'              => 'nullable|numeric',
            'date_of_birth'      => 'required|date',
            'location_id'        => 'required',
            'primary_instrument' => 'required',
            'plan'               => 'required',

            'parent_first_name'  => $request->age < 18 ? 'required' : 'nullable',
            'parent_second_name' => $request->age < 18 ? 'required' : 'nullable',
            'parent_email'       => $request->age < 18 ? 'required|email' : 'nullable',
            'parent_phone'       => $request->age < 18 ? 'required|numeric' : 'nullable',
        ]);
        try {
            DB::beginTransaction();
            $user = User::where('id',$request->user_id)->first();
            if($user){
                if($user->email == null){
                    $randomUserPassword = Str::random(10);
                    $user->password = Hash::make($randomUserPassword);
                    $data = [
                        'name'     => $user->first_name,
                        'password' => $randomUserPassword,
                    ];
                    Mail::to($request->email)->send(new SendPasswordEmail($data));
                }
                $user->first_name = isset($request->first_name) ? $request->first_name : '';
                $user->second_name = isset($request->second_name) ? $request->second_name : '';
                $user->email = isset($request->email) ? $request->email : '';
                $user->phone = isset($request->phone) ? $request->phone : '';
                $user->update();
            } else {
                return redirect()->back()->with('error','User not found'); 
            }

            $student = Student::where('id',$request->id)->first();
            if($student){
                if(isset($request->age) && $request->age < 18){
                    $student->type = "0";
                } else {
                    $student->type = "1";
                }
                $student->user_id = $user->id;
                $student->date_of_birth = isset($request->date_of_birth) ? $request->date_of_birth : '';
                $student->location_id = isset($request->location_id) ? $request->location_id : '';
                $student->primary_instrument = isset($request->primary_instrument) ? $request->primary_instrument : '';
                $student->plan = isset($request->plan) ? $request->plan : '';

                $student->update();
            }

            if(isset($request->age) && $request->age < 18){
                $parentUser = User::where('id',$request->parent_user_id)->first();
                if(!$parentUser){
                    $parentUser = new User();
                    $parentUser->first_name = isset($request->parent_first_name) ? $request->parent_first_name : '';
                    $parentUser->second_name = isset($request->parent_second_name) ? $request->parent_second_name : '';
                    $parentUser->phone = isset($request->parent_phone) ? $request->parent_phone : '';
                    $parentUser->email = isset($request->parent_email) ? $request->parent_email : '';

                    $randomParentPassword = Str::random(10);
                    $parentUser->password = Hash::make($randomParentPassword);
                    $role = Role::where('name','Parent')->first();
                    if($role){
                        $parentUser->assignRole($role->name);
                    }

                    $parentUser->save();

                    $data = [
                        'name'     => $parentUser->first_name,
                        'password' => $randomParentPassword,
                    ];
                    Mail::to($parentUser->email)->send(new SendPasswordEmail($data));
                } else {
                    $parentUser->first_name = isset($request->parent_first_name) ? $request->parent_first_name : '';
                    $parentUser->second_name = isset($request->parent_second_name) ? $request->parent_second_name : '';
                    $parentUser->phone = isset($request->parent_phone) ? $request->parent_phone : '';
                    $parentUser->email = isset($request->parent_email) ? $request->parent_email : '';
                    $parentUser->update();
                }
            }

            if(isset($request->age) && $request->age < 18){
                $parent = UserParent::where('parent_of_student',$request->id)->first();
                if(!$parent){
                    $parent = new UserParent();
                }
                $parent->user_id = $parentUser->id;
                $parent->parent_of_student = $student->id;
                $parent->save();
            } else {
                $parent = UserParent::where('parent_of_student',$request->id)->first();
                if($parent){
                    $user = User::where('id',$parent->user_id)->first();
                    if($user){
                        if(File::exists(public_path($user->profile_image))){
                            File::delete(public_path($user->profile_image));
                        }

                        $originalEmailParts = explode('@', $user->email);
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
                        
                        $user->email = $newEmail;
                        $user->save();

                        $user->delete();
                    }
                    $parent->delete();
                }
            }

            DB::commit();
            return redirect()->route('admin.student.index')->with('success','Student updated sucessfully'); 
            
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('admin student update Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function destroy($id)
    {
        try {
            $student = Student::where('id',$id)->first();
            if($student){
                $parent = UserParent::where('parent_of_student',$student->id)->first();
                if($parent){
                    $user = User::where('id',$parent->user_id)->first();
                    if($user){
                        if(File::exists(public_path($user->profile_image))){
                            File::delete(public_path($user->profile_image));
                        }

                        $originalEmailParts = explode('@', $user->email);
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
                        
                        $user->email = $newEmail;
                        $user->save();
                        
                        $user->delete();
                    }
                    $parent->delete();
                }
                $user = User::where('id',$student->user_id)->first();
                if($user){
                    if(File::exists(public_path($user->profile_image))){
                        File::delete(public_path($user->profile_image));
                    }

                    $originalEmailParts = explode('@', $user->email);
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
                    
                    $user->email = $newEmail;
                    $user->save();

                    $user->delete();
                }
                $student->delete();
                return redirect()->route('admin.student.index')->with('success','Student deleted sucessfully'); 
            } else {
                return redirect()->back()->with('error','Student not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin student destroy Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');    
        }
    }

    public function getStudent(Request $request)
    {
      
        // Page Length
        $pageNumber = ($request->start / $request->length )+1;
        $pageLength = $request->length;
        $skip       = ($pageNumber-1) * $pageLength;

        // Page Order
        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        $query = Student::with('userInfo');
        // Search
        $search = $request->search;
        $query->whereHas('userInfo', function ($q) use ($search) {
            $q->where('first_name', 'like', "%".$search."%")
                ->orWhere('second_name', 'like', "%".$search."%")
                ->orWhere('email', 'like', "%".$search."%")
                ->orWhere('phone', 'like', "%".$search."%");
        });

        $orderByName = 'students.id';
        switch ($orderColumnIndex) {
            case '0':
                $orderByName = 'students.id';
                break;
            case '1':
                $orderByName = 'users.first_name';
                break;
            case '2':
                $orderByName = 'users.email';
                break;
            case '3':
                $orderByName = 'users.phone';
                break;
        }
        $query = $query->join('users', 'users.id', '=', 'students.user_id')
                   ->orderBy($orderByName, $orderBy);
        $recordsFiltered = $recordsTotal = $query->count();
        $students = $query->skip($skip)->take($pageLength)
        ->select('students.*', 'users.first_name', 'users.email', 'users.phone')
        ->get();
        return response()->json([
            "draw"=> $request->draw, 
            "recordsTotal"=> $recordsTotal, 
            "recordsFiltered" => $recordsFiltered, 
            "data" => $students->map(function($student) {
                return [
                    'id' => $student->id,
                    'fullName' => $student->fullName,
                    'email' => $student->userInfo->email ? $student->userInfo->email : $student->parentInfo->userInfo->email,
                    'phone' => $student->userInfo->phone ? $student->userInfo->phone : $student->parentInfo->userInfo->phone,
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
