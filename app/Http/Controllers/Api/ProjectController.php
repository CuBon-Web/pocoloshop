<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Project;
use App\Services\CloudflareImageService;

class ProjectController extends Controller
{
    protected $apiToken;
    protected $accountId;
    protected $cloudflareService;

    public function __construct(CloudflareImageService $cloudflareService)
    {
        $this->cloudflareService = $cloudflareService;
    }
    public function create(Request $request, Project $ser)
    {
    	$data = $ser->saveProject($request);
        return response()->json([
    		'message' => 'Save Success',
    		'data'=> $data
    	],200);
    }
    public function list(Request $request)
    {
    	$keyword = $request->keyword;
        if($keyword == ""){
            $data = Project::orderBy('id','DESC')->get(['id','name','created_at','images']);
        }else{
            $data = Project::where('title', 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->get()->toArray();
        }
        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }
    public function delete($id)
    {
        $query = Project::find($id);
        
        $arrimg = json_decode($query->images);
        foreach($arrimg as $url){
            $this->cloudflareService->deleteImage($url);
        }
        $query->delete();
        return response()->json(['message'=>'Delete Success'],200);
    }
    public function edit($id)
    {
        $data = Project::where([
            'id'=> $id
        ])
        ->first();
        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }
}
