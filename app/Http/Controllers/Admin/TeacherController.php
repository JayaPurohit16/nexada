<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendPasswordEmail;
use App\Models\Instrument;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:teacher-list', ['only' => ['index']]);
        $this->middleware('permission:teacher-create', ['only' => ['create','store']]);
        $this->middleware('permission:teacher-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:teacher-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        try {
            $teachers = Teacher::get();
            return view('admin.teacher.index',compact('teachers'));
        } catch (Exception $e) {
            Log::info('admin teacher index Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');      
        }
    }

    public function create()
    {
        try {
            $instruments = Instrument::get();
            return view('admin.teacher.create',compact('instruments'));
        } catch (Exception $e) {
            Log::info('admin teacher create Error---' . $e->getMessage());
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
            // 'newPassword' => 'required|min:6',
            // 'confirmPassword' => 'required|same:newPassword',
            'instrument_id'   => 'required|array',
            'instrument_id.*' => 'exists:instruments,id',
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

                if ($request->hasFile('image')) {
                    if(File::exists(public_path($user->profile_image))){
                        File::delete(public_path($user->profile_image));
                    }
                    $image = $request->file('image');
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $newFileName = str_replace(['(', ')', ' '], ['', '', ''], $imageName);
                    $image->move(public_path('uploads/profile-image/'), $newFileName);
                    $user->profile_image = 'uploads/profile-image/' . $newFileName;
                }
                $role = Role::where('name','Teacher')->first();
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
                    Mail::to($user->email)->send(new SendPasswordEmail($data));
                }
                
                $teacher = new Teacher();
                $teacher->user_id = $user->id;
                $teacher->instruments_can_teach = implode(',',$request->instrument_id);
                $teacher->save();

                DB::commit();
                return redirect()->route('admin.teacher.index')->with('success','Teacher created sucessfully'); 
            
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('admin teacher store Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function edit($id)
    {
        try {
            $teacher = Teacher::where('id',$id)->first();
            $instruments = Instrument::get();
            $selectedInstruments = explode(',', $teacher->instruments_can_teach);
            if($teacher){
                return view('admin.teacher.edit',compact('teacher','instruments','selectedInstruments'));
            } else {
                return redirect()->back()->with('error','Teacher not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin teacher edit Error---' . $e->getMessage());
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
                Rule::unique('users')->ignore($request->user_id),
            ],
            'instrument_id'   => 'required|array',
            'instrument_id.*' => 'exists:instruments,id',
        ]);
        try {
            DB::beginTransaction();
            $teacher = Teacher::where('id',$request->id)->first();
            if($teacher){
                $existingEmail = User::where('email', $request->name)->where('id', '!=', $teacher->user_id)->first();
                if ($existingEmail) {
                return redirect()->back()->with('error', 'Email already exists');
                }
                $user = User::where('id',$teacher->user_id)->first();
                if($user){
                    $user->first_name = isset($request->first_name) ? $request->first_name : '';
                    $user->second_name = isset($request->second_name) ? $request->second_name : '';
                    $user->phone = isset($request->phone) ? $request->phone : '';
                    $user->email = isset($request->email) ? $request->email : '';

                    if ($request->hasFile('image')) {
                        if(File::exists(public_path($user->profile_image))){
                            File::delete(public_path($user->profile_image));
                        }
                        $image = $request->file('image');
                        $imageName = time() . '_' . $image->getClientOriginalName();
                        $newFileName = str_replace(['(', ')', ' '], ['', '', ''], $imageName);
                        $image->move(public_path('uploads/profile-image/'), $newFileName);
                        $user->profile_image = 'uploads/profile-image/' . $newFileName;
                    }
                    $user->update();
                } else {
                    return redirect()->back()->with('error', 'User not found');
                }

                $teacher->instruments_can_teach = implode(',',$request->instrument_id);
                $teacher->update();
            } else {
                return redirect()->back()->with('error','Teacher not found'); 
            }
            DB::commit();
            return redirect()->route('admin.teacher.index')->with('success','Teacher updated sucessfully'); 
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('admin teacher update Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    // public function destroy($id)
    // {
    //     try {
    //         $teacher = Teacher::where('id',$id)->first();
    //         if($teacher){
    //             $user = User::where('id',$teacher->user_id)->first();
    //             if($user){
    //                 if(File::exists(public_path($user->profile_image))){
    //                     File::delete(public_path($user->profile_image));
    //                 }
    //                 $user->delete();

    //                 $originalEmailParts = explode('@', $user->email);
    //                 $baseEmail = $originalEmailParts[0];
    //                 $domain = $originalEmailParts[1];

    //                 $lastUser = User::withTrashed()
    //                     ->where('email', 'LIKE', "$baseEmail")
    //                     ->orderBy('id', 'desc')
    //                     ->first();

    //                 if ($lastUser) {
    //                     $lastEmailParts = explode('@', $lastUser->email);
    //                     $lastBaseEmail = explode('_backup', $lastEmailParts[0]);
    //                     $suffix = isset($lastBaseEmail[1]) ? $lastBaseEmail[1] + 1 : 1;
    //                     $newEmail = "{$lastBaseEmail[0]}_backup{$suffix}@{$domain}";
    //                 } else {
    //                     $newEmail = "{$baseEmail}_backup1@{$domain}";
    //                 }

    //                 $user->update(['email' => $newEmail]);

    //             }
    //             $teacher->delete();
    //             return redirect()->route('admin.teacher.index')->with('success','Teacher deleted sucessfully'); 
    //         } else {
    //             return redirect()->back()->with('error','Teacher not found'); 
    //         }
    //     } catch (Exception $e) {
    //         Log::info('admin teacher destroy Error---' . $e->getMessage());
    //         return redirect()->back()->with('error', 'Something went wrong');    
    //     }
    // }

    public function destroy($id)
    {
        try {
            $teacher = Teacher::where('id', $id)->first();
            if ($teacher) {
                $user = User::where('id', $teacher->user_id)->first();
                if ($user) {
                    if (File::exists(public_path($user->profile_image))) {
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

                $teacher->delete();
                return redirect()->route('admin.teacher.index')->with('success', 'Teacher deleted successfully');
            } else {
                return redirect()->back()->with('error', 'Teacher not found');
            }
        } catch (Exception $e) {
            Log::info('admin teacher destroy Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }


    public function getTeacher(Request $request)
    {
      
        // Page Length
        $pageNumber = ($request->start / $request->length )+1;
        $pageLength = $request->length;
        $skip       = ($pageNumber-1) * $pageLength;

        // Page Order
        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        $query = Teacher::with('userInfo');
        // Search
        $search = $request->search;
        $query->whereHas('userInfo', function ($q) use ($search) {
            $q->where('first_name', 'like', "%".$search."%")
                ->orWhere('second_name', 'like', "%".$search."%")
                ->orWhere('email', 'like', "%".$search."%")
                ->orWhere('phone', 'like', "%".$search."%");
        });

        $orderByName = 'teachers.id';
        switch ($orderColumnIndex) {
            case '0':
                $orderByName = 'teachers.id';
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
        $query = $query->join('users', 'users.id', '=', 'teachers.user_id')
                   ->orderBy($orderByName, $orderBy);
        $recordsFiltered = $recordsTotal = $query->count();
        $teachers = $query->skip($skip)->take($pageLength)
        ->select('teachers.*', 'users.first_name', 'users.email', 'users.phone')
        ->get();
        return response()->json([
            "draw"=> $request->draw, 
            "recordsTotal"=> $recordsTotal, 
            "recordsFiltered" => $recordsFiltered, 
            "data" => $teachers->map(function($teacher) {
                return [
                    'id' => $teacher->id,
                    'fullName' => $teacher->fullName,
                    'email' => $teacher->userInfo->email,
                    'phone' => $teacher->userInfo->phone,
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
