<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\RegistrationFee;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:subscription-list', ['only' => ['index']]);
        $this->middleware('permission:subscription-create', ['only' => ['create','store']]);
        $this->middleware('permission:subscription-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:subscription-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        try {
            $registrationFee = RegistrationFee::first();
            return view('admin.subscription.index',compact('registrationFee'));
        } catch (Exception $e) {
            Log::info('admin subcription index Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');      
        }
    }

    public function create()
    {
        try {
            $locations = Location::get();
            return view('admin.subscription.create',compact('locations'));
        } catch (Exception $e) {
            Log::info('admin subscription create Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');      
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'lesson_per_week' => 'required|integer',
            'time' => 'required|integer',
            // 'amount' => 'required|array',
            // 'billing_period' => 'required|array',
            // 'discount' => 'required|integer|array',
            'amount_of_free_lessons' => 'required|integer',
            'location_id' => 'required',
            'new_sign_up_allowed' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg', 
        ]);
        try {
            $subscription = new Subscription();
            $subscription->name = isset($request->name) ? $request->name : '';
            $subscription->lesson_per_week =  isset($request->lesson_per_week) ? $request->lesson_per_week : '';
            $subscription->time = isset($request->time) ? $request->time : '';
            // $subscription->amount = isset($request->amount) ? $request->amount : '';
            // $subscription->billing_period = isset($request->billing_period) ? $request->billing_period : '';
            // $subscription->discount = isset($request->discount) ? $request->discount : '';
            $subscription->amount_of_free_lessons = isset($request->amount_of_free_lessons) ? $request->amount_of_free_lessons : '';
            $subscription->location_id = isset($request->location_id) ? $request->location_id : '';
            $subscription->new_sign_up_allowed = isset($request->new_sign_up_allowed) ? $request->new_sign_up_allowed : '';
            $subscription->description = isset($request->description) ? $request->description : '';

            if ($request->hasFile('image')) {

                if(File::exists(public_path($subscription->image))){
                    File::delete(public_path($subscription->image));
                }

                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $newFileName = str_replace(['(', ')', ' '], ['', '', ''], $imageName);
                $image->move(public_path('uploads/subscription-image/'), $newFileName);
                $subscription->image = 'uploads/subscription-image/' . $newFileName;
            }

            $subscription->save();

            $prices = $request->price;
            $billingPeriods = $request->billing_period;
            $discounts = $request->discount;
    
            $count = count($prices);
    
            for ($i = 0; $i < $count; $i++) {
                if($billingPeriods[$i] != null){
                    $subscriptionType = new SubscriptionType();
                    $subscriptionType->subscription_id = $subscription->id;
                    $subscriptionType->amount = $prices[$i];
                    $subscriptionType->billing_period = $billingPeriods[$i];
                    $subscriptionType->discount = $discounts[$i];
                    $subscriptionType->save();
                }
            }

            return redirect()->route('admin.subscription.index')->with('success','Subscription created sucessfully'); 
            
        } catch (Exception $e) {
            Log::info('admin subscription store Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');      
        }
    }

    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     try {
    //         $subscriptions = $request->input('subscriptions');

    //         foreach ($subscriptions as $index => $subscriptionData) {
    //             $subscription = Subscription::where('id',$subscriptionData['subscription_id'])->first();
    //             if ($subscription) {
    //                 $subscription->description = $subscriptionData['description'];
    //                 $subscription->lesson_per_week = $subscriptionData['lesson_per_week'];
    //                 $subscription->time = $subscriptionData['time'];
    //                 $subscription->amount = $subscriptionData['amount'];
    //                 $subscription->billing_period = $subscriptionData['billing_period'];
    //                 $subscription->discount = $subscriptionData['discount'];
    //                 $subscription->amount_of_free_lessons = $subscriptionData['amount_of_free_lessons'];
    //                 $subscription->location_id = $subscriptionData['location'];
    //                 $subscription->new_sign_up_allowed = $subscriptionData['new_sign_up_allowed'];

    //                 $file = $request->file('subscriptions.' . $index . '.image');
                
    //                 if ($file) {
    //                     if (File::exists(public_path($subscription->image))) {
    //                         File::delete(public_path($subscription->image));
    //                     }
    
    //                     // Handle new image upload
    //                     $imageName = rand(11111111, 99999999) . '_' . $file->getClientOriginalName();
    //                     $newFileName = str_replace(['(', ')', ' '], ['', '', ''], $imageName);
    //                     $file->move(public_path('uploads/subscription-image/'), $newFileName);
    //                     $subscription->image = 'uploads/subscription-image/' . $newFileName;
    //                 }
    //                 $subscription->save();
    //             }
    //         }

    //         return redirect()->route('admin.subscription.index')->with('success', 'Subscriptions updated successfully');
    //     } catch (Exception $e) {
    //         Log::info('admin subscription store Error---' . $e->getMessage());
    //         return redirect()->back()->with('error', 'Something went wrong');
    //     }
    // }


    public function edit($id)
    {
        try {
            $subscription = Subscription::where('id',$id)->first();
            $locations = Location::get();
            $subscriptionTypes = SubscriptionType::where('subscription_id',$subscription->id)->get();
            if($subscription){
                return view('admin.subscription.edit',compact('subscription','locations','subscriptionTypes'));
            } else {
                return redirect()->back()->with('error','Subscription not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin subscription edit Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');      
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required',
            'lesson_per_week' => 'required|integer',
            'time' => 'required|integer',
            // 'amount.*' => 'required',
            // 'billing_period.*' => 'required',
            // 'discount.*' => 'required|integer',
            'amount_of_free_lessons' => 'required|integer',
            'location_id' => 'required',
            'new_sign_up_allowed' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg', 
        ]);
        try {
            DB::beginTransaction();
            $subscription = Subscription::where('id',$request->id)->first();
            if($subscription){
            $subscription->name = isset($request->name) ? $request->name : '';
            $subscription->lesson_per_week =  isset($request->lesson_per_week) ? $request->lesson_per_week : '';
            $subscription->time = isset($request->time) ? $request->time : '';
            // $subscription->amount = isset($request->amount) ? $request->amount : '';
            // $subscription->billing_period = isset($request->billing_period) ? $request->billing_period : '';
            // $subscription->discount = isset($request->discount) ? $request->discount : '';
            $subscription->amount_of_free_lessons = isset($request->amount_of_free_lessons) ? $request->amount_of_free_lessons : '';
            $subscription->location_id = isset($request->location_id) ? $request->location_id : '';
            $subscription->new_sign_up_allowed = isset($request->new_sign_up_allowed) ? $request->new_sign_up_allowed : '';
            $subscription->description = isset($request->description) ? $request->description : '';

            if ($request->hasFile('image')) {

                if(File::exists(public_path($subscription->image))){
                    File::delete(public_path($subscription->image));
                }

                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $newFileName = str_replace(['(', ')', ' '], ['', '', ''], $imageName);
                $image->move(public_path('uploads/subscription-image/'), $newFileName);
                $subscription->image = 'uploads/subscription-image/' . $newFileName;
            }
            $subscription->update(); 

            $prices = ($request->price) ? $request->price : [];
            $billingPeriods = ($request->billing_period) ? $request->billing_period : [];
            $discounts = ($request->discount) ? $request->discount : [];
            $subscriptionTypeIds = ($request->subscriptionTypeId) ? $request->subscriptionTypeId : [];

            $count = max(count($prices), count($billingPeriods), count($discounts), count($subscriptionTypeIds));

            $subscriptionType = SubscriptionType::where('subscription_id',$subscription->id)->whereNotIn('id',$subscriptionTypeIds)->delete();
            for ($i = 0; $i < $count; $i++) {
                if($billingPeriods[$i] != null){
                    if (isset($subscriptionTypeIds[$i])) {
                        $subscriptionType = SubscriptionType::where('id', $subscriptionTypeIds[$i])->first();
                    } else {
                        $subscriptionType = new SubscriptionType();
                    }
                    if ($subscriptionType) {
                        $subscriptionType->subscription_id = $subscription->id;
                        $subscriptionType->amount = $prices[$i] ?? 0;
                        $subscriptionType->billing_period = $billingPeriods[$i] ?? null;
                        $subscriptionType->discount = $discounts[$i] ?? 0;
                        $subscriptionType->save();
                    }
                }
            }

            } else {
                return redirect()->back()->with('error','Subscription not found'); 
            }
            DB::commit();
            return redirect()->route('admin.subscription.index')->with('success','Subscription updated sucessfully'); 
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('admin subscription update Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');      
        }
    }

    public function destroy($id)
    {
        try {
            $subscription = Subscription::where('id',$id)->first();
            if($subscription){
                if(File::exists(public_path($subscription->image))){
                    File::delete(public_path($subscription->image));
                }
                $subscriptionTypes = SubscriptionType::where('subscription_id',$subscription->id)->get();
                if($subscriptionTypes){
                    foreach($subscriptionTypes as $subscriptionType){
                        $subscriptionType->delete();
                    }
                }
                $subscription->delete();
                return redirect()->route('admin.subscription.index')->with('success','Subscription deleted sucessfully'); 
            } else {
                return redirect()->back()->with('error','Subscription not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin subscription destroy Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');      
        }
    }

    public function getSubscription(Request $request)
    {
        // Page Length
        $pageNumber = ($request->start / $request->length )+1;
        $pageLength = $request->length;
        $skip       = ($pageNumber-1) * $pageLength;

        // Page Order
        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        $query = Subscription::with('location');
        // Search
        $search = $request->search;
        $query = $query->where(function($query) use ($search){
            $query->orWhere('name', 'like', "%".$search."%");
            $query->orWhere('lesson_per_week', 'like', "%".$search."%");
            $query->orWhere('time', 'like', "%".$search."%");
            $query->orWhere('amount', 'like', "%".$search."%");
            $query->orWhere('discount', 'like', "%".$search."%");
            $query->orWhere('amount_of_free_lessons', 'like', "%".$search."%");
        });

        $orderByName = 'id';
        switch($orderColumnIndex){
            case '0':
                $orderByName = 'id';
                break;
            case '1':
                $orderByName = 'name';
                break;
            case '2':
                $orderByName = 'lesson_per_week';
                break;
            case '3':
                $orderByName = 'time';
                break;
            case '4':
                $orderByName = 'amount';
                break;
            case '5':
                $orderByName = 'discount';
                break;
            case '6':
                $orderByName = 'amount_of_free_lessons';
                break;        
        }
        $query = $query->orderBy($orderByName, $orderBy);
        $recordsFiltered = $recordsTotal = $query->count();
        $subscription = $query->skip($skip)->take($pageLength)->get();

        return response()->json(["draw"=> $request->draw, "recordsTotal"=> $recordsTotal, "recordsFiltered" => $recordsFiltered, 'data' => $subscription], 200);
    }

    public function storeRegistrationFee(Request $request)
    {
        $validated = $request->validate([
            'price' => 'required',
        ]);
        try {
            $registrationFee = RegistrationFee::first();
            if(!$registrationFee){
                $registrationFee = new RegistrationFee();
            }
            $registrationFee->price = isset($request->price) ? $request->price : '';
            $registrationFee->save(); 
            return redirect()->route('admin.subscription.index')->with('success','Registration fee updated sucessfully'); 
        } catch (Exception $e) {
            Log::info('admin subscription registration fee store Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');      
        }
    }

    public function deleteImage(Request $request)
    {
        try {
            $subscription = Subscription::where('id',$request->id)->first();
            if($subscription){
                if(File::exists(public_path($subscription->image))){
                    File::delete(public_path($subscription->image));
                }
                $subscription->image = null;
                $subscription->update();
            }
            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            Log::error('File deletion failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete the file.'], 500);
        }
    }
}
