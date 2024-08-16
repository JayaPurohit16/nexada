<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use App\Models\Location;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            return view('admin.dashboard');
        } catch (Exception $e) {
            Log::info('admin dashboard Error---' . $e->getMessage());
            return redirect()->back()->with('Something went wrong');     
        }
    }

    public function profile()
    {
        try {
            $user = Auth::user();
            $teacher = Teacher::where('user_id',$user->id)->first();
            if($user->hasRole('Teacher') && $teacher){
                $locations = Location::get();
                $instruments = Instrument::get();
                $selectedInstruments = explode(',', $teacher->instruments_can_teach);
                return view('teacher.profile.profile',compact('user','locations','teacher','instruments','selectedInstruments'));
            }
            return view('admin.profile',compact('user'));
        } catch (Exception $e) {
            Log::info('admin profile Error---' . $e->getMessage());
            return redirect()->back()->with('error','Something went wrong');     
        }
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'second_name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(Auth::id()),
            ],
            'phone' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg'
        ]);
        try {
            $user = User::where('id',Auth::user()->id)->first();
            if($user){
                $user->first_name = isset($request->first_name) ? $request->first_name : '';
                $user->second_name = isset($request->second_name) ? $request->second_name : '';
                $user->email = isset($request->email) ? $request->email : '';
                $user->phone = isset($request->phone) ? $request->phone : '';

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

                $user->save();

                $teacher = Teacher::where('user_id',$user->id)->first();
                if($teacher){
                    $teacher->instruments_can_teach = implode(',',$request->instrument_id);
                    $teacher->location_id = $request->location_id;
                    $teacher->update();
                }
                return redirect()->back()->with('success','Profile updated successfully');
            } else {
                return redirect()->back()->with('error','User not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin profileUpdate Error---' . $e->getMessage());
            return redirect()->back()->with('error','Something went wrong');     
        }
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|same:newPassword',
        ]);
        try {
            $user = User::where('id',Auth::user()->id)->first();
            if($user){
                $user->password = Hash::make($request->newPassword);
                $user->update();
                return redirect()->back()->with('success','Password updated successfully');
            } else {
                return redirect()->back()->with('error','User not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin passwordUpdate Error---' . $e->getMessage());
            return redirect()->back()->with('error','Something went wrong');     
        }
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
