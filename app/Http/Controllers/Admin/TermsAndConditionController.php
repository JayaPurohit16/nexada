<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermsAndCondition;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TermsAndConditionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:terms_and_conditions-list', ['only' => ['index']]);
        $this->middleware('permission:terms_and_conditions-create', ['only' => ['create','store']]);
        $this->middleware('permission:terms_and_conditions-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:terms_and_conditions-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        try {
            $termsAndConditions = TermsAndCondition::first();
            return view('admin.terms_and_condition.index',compact('termsAndConditions'));
        } catch (Exception $e) {
            Log::info('admin terms and condition index Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function store(Request $request)
    {
        try {
            $termsAndConditions = TermsAndCondition::first();
            if(!$termsAndConditions){
                $termsAndConditions = new TermsAndCondition();
            }
            $termsAndConditions->title = isset($request->content) ? $request->content : null;
            $termsAndConditions->save();
            return redirect()->back()->with('success','Terms & Conditions updated successfully');
        } catch (Exception $e) {
            Log::info('admin terms and condition store Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }   
}
