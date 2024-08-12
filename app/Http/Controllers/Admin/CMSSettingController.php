<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsSettting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CMSSettingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:cms_setting-list', ['only' => ['index']]);
        $this->middleware('permission:cms_setting-create', ['only' => ['create','store']]);
        $this->middleware('permission:cms_setting-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:cms_setting-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        try {
            $cmsSettings = CmsSettting::pluck('value', 'key')->toArray();
            return view('admin.cms_settings.index',compact('cmsSettings'));
        } catch (Exception $e) {
            Log::info('admin cms setting index Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');    
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'website_logo' => 'nullable|image|mimes:png,jpg,jpeg',
            'favicon_logo' => 'nullable|image|mimes:png,jpg,jpeg',
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'youtube_link' => 'nullable|url',
        ]);

        try {
            $cmsSettings = CmsSettting::pluck('value', 'key')->toArray();

            if ($request->hasFile('website_logo')) {
                if(File::exists(public_path($cmsSettings['website_logo']))){
                    File::delete(public_path($cmsSettings['website_logo']));
                }
                $image = $request->file('website_logo');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $newFileName = str_replace(['(', ')', ' '], ['', '', ''], $imageName);
                $image->move(public_path('uploads/logo/'), $newFileName);
                CmsSettting::updateOrCreate(['key' => 'website_logo'], ['value' => 'uploads/logo/' . $newFileName]);
            }
       
            if ($request->hasFile('favicon_logo')) {
                if(File::exists(public_path($cmsSettings['favicon_logo']))){
                    File::delete(public_path($cmsSettings['favicon_logo']));
                }
                $image = $request->file('favicon_logo');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $newFileName = str_replace(['(', ')', ' '], ['', '', ''], $imageName);
                $image->move(public_path('uploads/favicon_logo/'), $newFileName);
                CmsSettting::updateOrCreate(['key' => 'favicon_logo'], ['value' => 'uploads/favicon_logo/' . $newFileName]);
            }
    
            $socialLinks = [
                'facebook_link' => $request->input('facebook_link'),
                'instagram_link' => $request->input('instagram_link'),
                'twitter_link' => $request->input('twitter_link'),
                'youtube_link' => $request->input('youtube_link'),
            ];
    
            foreach ($socialLinks as $key => $value) {
                CmsSettting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
    
            return redirect()->route('admin.CmsSetting.index')->with('success', 'Settings updated successfully.');
        } catch (Exception $e) {
            Log::error('CMS Settings Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
