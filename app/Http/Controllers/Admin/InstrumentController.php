<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instrument;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class InstrumentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:instrument-list', ['only' => ['index']]);
        $this->middleware('permission:instrument-create', ['only' => ['create','store']]);
        $this->middleware('permission:instrument-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:instrument-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        try {
            $instruments = Instrument::all();
            return view('admin.instrument.index',compact('instruments'));
        } catch (Exception $e) {
            Log::info('admin instrument index Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function create()
    {
        try {
            return view('admin.instrument.create');
        } catch (Exception $e) {
            Log::info('admin instrument create Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required',
            'tag'          => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg', 
        ]);
        try {
            $instrument = Instrument::where('name',$request->name)->first();
            if($instrument){
                return redirect()->back()->with('error','Instrument already exists'); 
            } else {
                $instrument = new Instrument();
                $instrument->name = isset($request->name) ? $request->name : '';
                $instrument->tag = isset($request->tag) ? $request->tag : '';

                if ($request->hasFile('image')) {

                    if(File::exists(public_path($instrument->image))){
                        File::delete(public_path($instrument->image));
                    }

                    $image = $request->file('image');
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $newFileName = str_replace(['(', ')', ' '], ['', '', ''], $imageName);
                    $image->move(public_path('uploads/instrument-image/'), $newFileName);
                    $instrument->image = 'uploads/instrument-image/' . $newFileName;
                }
                $instrument->save(); 
                return redirect()->route('admin.instrument.index')->with('success','Instrument created sucessfully'); 
            }
        } catch (Exception $e) {
            Log::info('admin Roles store Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function edit($id)
    {
        try {
            $instrument = Instrument::where('id',$id)->first();
            if($instrument){
                return view('admin.instrument.edit',compact('instrument'));
            } else {
                return redirect()->back()->with('error','Instrument not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin instrument edit Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');      
        }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required',
            'tag'          => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);
        try {
            $instrument = Instrument::where('id',$request->id)->first();
            if($instrument){
                $existingInstrument = Instrument::where('name', $request->name)->where('id', '!=', $instrument->id)->first();
                if ($existingInstrument) {
                return redirect()->back()->with('error', 'Instrument already exists');
                }
                $instrument->name = isset($request->name) ? $request->name : '';
                $instrument->tag = isset($request->tag) ? $request->tag : '';
                if ($request->hasFile('image')) {

                    if(File::exists(public_path($instrument->image))){
                        File::delete(public_path($instrument->image));
                    }

                    $image = $request->file('image');
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $newFileName = str_replace(['(', ')', ' '], ['', '', ''], $imageName);
                    $image->move(public_path('uploads/instrument-image/'), $newFileName);
                    $instrument->image = 'uploads/instrument-image/' . $newFileName;
                }
                $instrument->update(); 
            } else {
                return redirect()->back()->with('error','Instrument not found'); 
            }
            return redirect()->route('admin.instrument.index')->with('success','Instrument updated sucessfully'); 
        } catch (Exception $e) {
            Log::info('admin instrument update Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function destroy($id)
    {
        try {
            $instrument = Instrument::where('id',$id)->first();
            if($instrument){
                if(File::exists(public_path($instrument->image))){
                    File::delete(public_path($instrument->image));
                }
                $instrument->delete();
                return redirect()->route('admin.instrument.index')->with('success','Instrument deleted sucessfully'); 
            } else {
                return redirect()->back()->with('error','Instrument not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin instrument destroy Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');      
        }
    }

    public function getInstrument(Request $request)
    {
      
        // Page Length
        $pageNumber = ($request->start / $request->length )+1;
        $pageLength = $request->length;
        $skip       = ($pageNumber-1) * $pageLength;

        // Page Order
        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        $query = Instrument::query();
        // Search
        $search = $request->search;
        $query = $query->where(function($query) use ($search){
            $query->orWhere('name', 'like', "%".$search."%");
            $query->orWhere('tag', 'like', "%".$search."%");
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
                $orderByName = 'tag';
                break;
        }
        $query = $query->orderBy($orderByName, $orderBy);
        $recordsFiltered = $recordsTotal = $query->count();
        $instrument = $query->skip($skip)->take($pageLength)->get();

        return response()->json(["draw"=> $request->draw, "recordsTotal"=> $recordsTotal, "recordsFiltered" => $recordsFiltered, 'data' => $instrument], 200);
    }
}
