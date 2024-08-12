<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyAndPolicy;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PrivacyAndPolicyController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:privacy_and_policy-list', ['only' => ['index']]);
        $this->middleware('permission:privacy_and_policy-create', ['only' => ['create','store']]);
        $this->middleware('permission:privacy_and_policy-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:privacy_and_policy-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        try {
            $PrivacyAndPolicies = PrivacyAndPolicy::first();
            return view('admin.privacy_and_policy.index',compact('PrivacyAndPolicies'));
        } catch (Exception $e) {
            Log::info('admin privacy and policy index Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');    
        }
    }

    public function store(Request $request)
    {
        try {
            $PrivacyAndPolicies = PrivacyAndPolicy::first();
            if(!$PrivacyAndPolicies){
                $PrivacyAndPolicies = new PrivacyAndPolicy();
            }
            $PrivacyAndPolicies->title = isset($request->content) ? $request->content : null;
            $PrivacyAndPolicies->save();
            return redirect()->back()->with('success','Privacy & Policy updated successfully');
        } catch (Exception $e) {
            Log::info('admin privacy and policy store Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');    
        }
    }  
}
