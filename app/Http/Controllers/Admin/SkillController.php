<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExternalVideo;
use App\Models\Instrument;
use App\Models\Skill;
use App\Models\SkillNote;
use App\Models\SupportingDoc;
use App\Models\TutorialVideo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SkillController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:skill-list', ['only' => ['index']]);
        $this->middleware('permission:skill-create', ['only' => ['create','store']]);
        $this->middleware('permission:skill-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:skill-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        try {
            $skills = Skill::all();
            return view('admin.skill.index',compact('skills'));
        } catch (Exception $e) {
            Log::info('admin skill index Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function create()
    {
        try {
            $instruments = Instrument::get();
            return view('admin.skill.create',compact('instruments'));
        } catch (Exception $e) {
            Log::info('admin skill create Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required',
            'instrument_id' => 'required',
            'category'      => 'required', 
            'description'   => 'required',
        ]);
        try {
            DB::beginTransaction();
            $skill = Skill::where('name',$request->name)->where('instrument_id',$request->instrument_id)->first();
            if($skill){
                return redirect()->back()->with('error','Skill already exists'); 
            } else {
                $skill = new Skill();
                $skill->name = isset($request->name) ? $request->name : '';
                $skill->instrument_id = isset($request->instrument_id) ? $request->instrument_id : '';
                $skill->category = isset($request->category) ? $request->category : '';
                $skill->description = isset($request->description) ? $request->description : '';
                $skill->last_changes_by = isset(Auth::user()->id) ? Auth::user()->id : '';
                $skill->save();
                
                if(isset($request->external_videos)){
                    foreach($request->external_videos as $external_video){
                        if($external_video !== null && $external_video !== ''){
                            $externalVideo = new ExternalVideo();
                            $externalVideo->skill_id = $skill->id;
                            $externalVideo->name = $external_video;
                            $externalVideo->save();
                        }
                    }
                }
                if(isset($request->notes)){
                    foreach($request->notes as $note){
                        if($note !== null && $note !== ''){
                            $skillNote = new SkillNote();
                            $skillNote->skill_id = $skill->id;
                            $skillNote->name = $note;
                            $skillNote->save(); 
                        }
                    } 
                } 
                if(isset($request->supporting_docs)){
                    foreach($request->supporting_docs as $supporting_doc){
                        $supportingDoc = new SupportingDoc();
                        $supportingDoc->skill_id = $skill->id;
    
                        if ($supporting_doc) {
                            $video = $supporting_doc;
                            $videoName = rand(11111111, 99999999) . '_' . $video->getClientOriginalName();
                            $newFileName = str_replace(['(', ')', ' '], ['', '', ''], $videoName);
                            $video->move(public_path('uploads/supporting-doc/'), $newFileName);
                            $supportingDoc->name = 'uploads/supporting-doc/' . $newFileName;
                        }
                        $supportingDoc->save(); 
                    }
                }
                if(isset($request->tutorial_videos)){
                    foreach($request->tutorial_videos as $tutorial_video){
                        $tutorialVideo = new TutorialVideo();
                        $tutorialVideo->skill_id = $skill->id;
    
                        if ($tutorial_video) {
                            $video = $tutorial_video;
                            $videoName = rand(11111111, 99999999) . '_' . $video->getClientOriginalName();
                            $newFileName = str_replace(['(', ')', ' '], ['', '', ''], $videoName);
                            $video->move(public_path('uploads/tutorial-video/'), $newFileName);
                            $tutorialVideo->name = 'uploads/tutorial-video/' . $newFileName;
                        }
                        $tutorialVideo->save(); 
                    }
                }
                DB::commit();
                return redirect()->route('admin.skill.index')->with('success','Skill created sucessfully'); 
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('admin skill store Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function edit($id)
    {
        try {
            $skill = Skill::where('id',$id)->first();
            $instruments = Instrument::get();

            $externalVideos = ExternalVideo::where('skill_id',$id)->get();
            $tutorialVideos = TutorialVideo::where('skill_id',$id)->get();
            $supportingDocs = SupportingDoc::where('skill_id',$id)->get();
            $skillNotes = SkillNote::where('skill_id',$id)->get();
            if($skill){
                return view('admin.skill.edit',compact('skill','instruments','externalVideos','tutorialVideos','supportingDocs','skillNotes'));
            } else {
                return redirect()->back()->with('error','Skill not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin skill edit Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');      
        }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required',
            'instrument_id' => 'required',
            'category'      => 'required', 
            'description'   => 'required',
        ]);
        try {
            $skill = Skill::where('id',$request->id)->first();
            if($skill){
                $existingskill = Skill::where('name', $request->name)->where('instrument_id',$request->instrument_id)->where('id', '!=', $skill->id)->first();
                if ($existingskill) {
                return redirect()->back()->with('error', 'Skill already exists');
                }
                $skill->name = isset($request->name) ? $request->name : '';
                $skill->instrument_id = isset($request->instrument_id) ? $request->instrument_id : '';
                $skill->category = isset($request->category) ? $request->category : '';
                $skill->description = isset($request->description) ? $request->description : '';
                $skill->last_changes_by = isset(Auth::user()->id) ? Auth::user()->id : '';
                $skill->update(); 

                if(isset($request->external_videos)){
                    $externalVideos = ExternalVideo::where('skill_id',$skill->id)->delete();
                    foreach($request->external_videos as $external_video){
                        if($external_video !== null && $external_video !== ''){
                            $externalVideo = new ExternalVideo();
                            $externalVideo->skill_id = $skill->id;
                            $externalVideo->name = $external_video;
                            $externalVideo->save();
                        }
                    }
                }
                if(isset($request->notes)){
                    $skillNotes = SkillNote::where('skill_id',$skill->id)->delete();
                    foreach($request->notes as $note){
                        if($note !== null && $note !== ''){
                            $skillNote = new SkillNote();
                            $skillNote->skill_id = $skill->id;
                            $skillNote->name = $note;
                            $skillNote->save(); 
                        }
                    } 
                } 
                if(isset($request->supporting_docs)){
                    foreach($request->supporting_docs as $supporting_doc){
                        $supportingDoc = new SupportingDoc();
                        $supportingDoc->skill_id = $skill->id;
    
                        if ($supporting_doc) {
                            $video = $supporting_doc;
                            $videoName = rand(11111111, 99999999) . '_' . $video->getClientOriginalName();
                            $newFileName = str_replace(['(', ')', ' '], ['', '', ''], $videoName);
                            $video->move(public_path('uploads/supporting-doc/'), $newFileName);
                            $supportingDoc->name = 'uploads/supporting-doc/' . $newFileName;
                        }
                        $supportingDoc->save(); 
                    }
                }
                if(isset($request->tutorial_videos)){
                    foreach($request->tutorial_videos as $tutorial_video){
                        $tutorialVideo = new TutorialVideo();
                        $tutorialVideo->skill_id = $skill->id;
    
                        if ($tutorial_video) {
                            $video = $tutorial_video;
                            $videoName = rand(11111111, 99999999) . '_' . $video->getClientOriginalName();
                            $newFileName = str_replace(['(', ')', ' '], ['', '', ''], $videoName);
                            $video->move(public_path('uploads/tutorial-video/'), $newFileName);
                            $tutorialVideo->name = 'uploads/tutorial-video/' . $newFileName;
                        }
                        $tutorialVideo->save(); 
                    }
                }
            } else {
                return redirect()->back()->with('error','Skill not found'); 
            }
            return redirect()->route('admin.skill.index')->with('success','Skill updated sucessfully'); 
        } catch (Exception $e) {
            Log::info('admin skill update Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');     
        }
    }

    public function destroy($id)
    {
        try {
            $skill = Skill::where('id',$id)->first();
            if($skill){

                $externalVideos = ExternalVideo::where('skill_id',$skill->id)->get();
                if($externalVideos){
                    foreach($externalVideos as $externalVideo){
                        $externalVideo->delete();
                    }
                }
                $skillnotes = SkillNote::where('skill_id',$skill->id)->get();
                if($skillnotes){
                    foreach($skillnotes as $skillnote){
                        $skillnote->delete();
                    }
                }
                $tutorialVideos = TutorialVideo::where('skill_id',$skill->id)->get();
                if($tutorialVideos){
                    foreach($tutorialVideos as $tutorialVideo){
                        if(File::exists(public_path($tutorialVideo->name))){
                            File::delete(public_path($tutorialVideo->name));
                        }
                        $tutorialVideo->delete();
                    }
                }
                $supportingDocs = SupportingDoc::where('skill_id',$skill->id)->get();
                if($supportingDocs){
                    foreach($supportingDocs as $supportingDoc){
                        if(File::exists(public_path($supportingDoc->name))){
                            File::delete(public_path($supportingDoc->name));
                        }
                        $supportingDoc->delete();
                    }
                }
                $skill->delete();
                return redirect()->route('admin.skill.index')->with('success','Skill deleted sucessfully'); 
            } else {
                return redirect()->back()->with('error','Skill not found'); 
            }
        } catch (Exception $e) {
            Log::info('admin skill destroy Error---' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');      
        }
    }

    public function getSkill(Request $request)
    {
      
        // Page Length
        $pageNumber = ($request->start / $request->length )+1;
        $pageLength = $request->length;
        $skip       = ($pageNumber-1) * $pageLength;

        // Page Order
        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        // $query = Skill::with('instrument')->query();
        $query = Skill::with('instrument');
        // Search
        $search = $request->search;
        $query = $query->where(function($query) use ($search){
            $query->orWhere('name', 'like', "%".$search."%");
            $query->orWhere('category', 'like', "%".$search."%");
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
                $orderByName = 'category';
                break;
        }
        $query = $query->orderBy($orderByName, $orderBy);
        $recordsFiltered = $recordsTotal = $query->count();
        $skill = $query->skip($skip)->take($pageLength)->get();

        return response()->json(["draw"=> $request->draw, "recordsTotal"=> $recordsTotal, "recordsFiltered" => $recordsFiltered, 'data' => $skill], 200);
    }

    public function deleteSupportDoc(Request $request)
    {
        try {
            $supportingDoc = SupportingDoc::where('id',$request->id)->first();
            if($supportingDoc){
                if(File::exists(public_path($supportingDoc->name))){
                    File::delete(public_path($supportingDoc->name));
                }
                $supportingDoc->delete();
            }
            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            Log::error('File deletion failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete the file.'], 500);
        }
    }

    public function deleteTutorialVideo(Request $request)
    {
        try {
            $tutorialVideo = TutorialVideo::where('id',$request->id)->first();
            if($tutorialVideo){
                if(File::exists(public_path($tutorialVideo->name))){
                    File::delete(public_path($tutorialVideo->name));
                }
                $tutorialVideo->delete();
            }
            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            Log::error('File deletion failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete the file.'], 500);
        }
    }
}
