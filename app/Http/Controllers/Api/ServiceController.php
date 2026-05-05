<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Services;
use App\Services\CloudflareImageService;

class ServiceController extends Controller
{
    protected $apiToken;
    protected $accountId;
    protected $cloudflareService;

    public function __construct(CloudflareImageService $cloudflareService)
    {
        $this->cloudflareService = $cloudflareService;
    }
    public function create(Request $request, Services $ser)
    {
    	$data = $ser->saveServices($request);
        return response()->json([
    		'message' => 'Save Success',
    		'data'=> $data
    	],200);
    }
    public function list(Request $request)
    {
    	$keyword = $request->keyword;
        if($keyword == ""){
            $data = Services::orderBy('id','DESC')->get(['id','name','created_at','image']);
        }else{
            $data = Services::where('title', 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->get()->toArray();
        }
        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }
    public function delete($id)
    {
        $query = Services::find($id);
        if($query->image != ''){
            $urlimg =  $query->image;
            $this->cloudflareService->deleteImage($urlimg);
        }
        $query->delete();
        return response()->json(['message'=>'Delete Success'],200);
    }
    public function edit($id)
    {
        $data = Services::where([
            'id'=> $id
        ])
        ->first();
        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }
}
