<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Subscription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:location-list', ['only' => ['index']]);
        $this->middleware('permission:location-create', ['only' => ['create','store']]);
        $this->middleware('permission:location-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:location-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        try {
            $locations = Location::all();
            return view('admin.location.index',compact('locations'));
        } catch (Exception $e) {
            Log::info('admin location index Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function create()
    {
        try {
            return view('admin.location.create');
        } catch (Exception $e) {
            Log::info('admin location create Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                    => 'required',
            'phone'                   => 'required',
            'address'                 => 'required',
            'calender_by_instruments' => 'nullable',
            'api_key'                 => 'nullable',
            'api_secret_key'          => 'nullable',
        ]);
        try {
            DB::beginTransaction();
            $location = Location::where('name',$request->name)->first();
            if($location){
                return redirect()->back()->with('error','Location already exists'); 
            } else {
                $location = new Location();
                $location->name = isset($request->name) ? $request->name : '';
                $location->phone = isset($request->phone) ? $request->phone : '';
                $location->address = isset($request->address) ? $request->address : '';
                $location->calender_by_instruments = isset($request->calender_by_instruments) ? $request->calender_by_instruments : '';
                $location->api_key = isset($request->api_key) ? $request->api_key : '';
                $location->api_secret_key = isset($request->api_secret_key) ? $request->api_secret_key : '';
                $location->save();

                // $subscription = new Subscription();
                // $subscription->name = "Basic Package";
                // $subscription->location_id = $location->id;
                // $subscription->save();

                // $subscription = new Subscription();
                // $subscription->name = "Family Discount";
                // $subscription->location_id = $location->id;
                // $subscription->save();

                // $subscription = new Subscription();
                // $subscription->name = "Double Package";
                // $subscription->location_id = $location->id;
                // $subscription->save();

                DB::commit();
                return redirect()->route('admin.location.index')->with('success','Location created sucessfully'); 
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('admin location store Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function edit($id)
    {
        try {
            $location = Location::where('id',$id)->first();
            if($location){
                return view('admin.location.edit',compact('location'));
            } else {
                return redirect()->back()->with('error','Location not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin location edit Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');   
        }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'                    => 'required',
            'phone'                   => 'required',
            'address'                 => 'required',
            'calender_by_instruments' => 'nullable',
            'api_key'                 => 'nullable',
            'api_secret_key'          => 'nullable',
        ]);
        try {
            $location = Location::where('id',$request->id)->first();
            if($location){
                $existingLocation = Location::where('name', $request->name)->where('id', '!=', $location->id)->first();
                if ($existingLocation) {
                return redirect()->back()->with('error', 'Location already exists');
                }
                $location->name = isset($request->name) ? $request->name : '';
                $location->phone = isset($request->phone) ? $request->phone : '';
                $location->address = isset($request->address) ? $request->address : '';
                $location->calender_by_instruments = isset($request->calender_by_instruments) ? $request->calender_by_instruments : '';
                $location->api_key = isset($request->api_key) ? $request->api_key : '';
                $location->api_secret_key = isset($request->api_secret_key) ? $request->api_secret_key : '';
                $location->update(); 
            } else {
                return redirect()->back()->with('error','Location not found'); 
            }
            return redirect()->route('admin.location.index')->with('success','Location updated sucessfully'); 
        } catch (Exception $e) {
            Log::info('admin location update Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function destroy($id)
    {
        try {
            $location = Location::where('id',$id)->first();
            if($location){
                $location->delete();
                // $subscriptions = Subscription::where('location_id',$location->id)->get();
                // if($subscriptions){
                //     foreach($subscriptions as $subscription){
                //         $subscription->delete();
                //     }
                // }
                return redirect()->route('admin.location.index')->with('success','Location deleted sucessfully'); 
            } else {
                return redirect()->back()->with('error','Location not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin location destroy Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');    
        }
    }

    public function getLocation(Request $request)
    {
      
        // Page Length
        $pageNumber = ($request->start / $request->length )+1;
        $pageLength = $request->length;
        $skip       = ($pageNumber-1) * $pageLength;

        // Page Order
        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'asc';

        $query = Location::query();
        // Search
        $search = $request->search;
        $query = $query->where(function($query) use ($search){
            $query->orWhere('name', 'like', "%".$search."%");
            $query->orWhere('phone', 'like', "%".$search."%");
        });

        $orderByName = 'id';
        switch($orderColumnIndex){
            case '0':
                $orderByName = 'id';
                break;
            case '1':
                $orderByName = 'name';
                break;
            case '3':
                $orderByName = 'phone';
                break;
            case '4':
                $orderByName = 'calender_by_instruments';
                break;
        
        }
        $query = $query->orderBy($orderByName, $orderBy);
        $recordsFiltered = $recordsTotal = $query->count();
        $subscription = $query->skip($skip)->take($pageLength)->get();

        return response()->json(["draw"=> $request->draw, "recordsTotal"=> $recordsTotal, "recordsFiltered" => $recordsFiltered, 'data' => $subscription], 200);
    }
}
