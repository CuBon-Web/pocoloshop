<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\ServiceCate;
use App\Services\CloudflareImageService;
class ServiceCateController extends Controller
{
    protected $apiToken;
    protected $accountId;
    protected $cloudflareService;

    public function __construct(CloudflareImageService $cloudflareService)
    {
        $this->cloudflareService = $cloudflareService;
    }
    public function add(Request $request, ServiceCate $category)
    {
        $data = $category->saveCate($request);
        return response()->json([
    		'message' => 'Save Success',
    		'data'=> $data
    	],200);
    }
    public function list(Request $request)
    {
        $keyword = $request->keyword;
        if($keyword == ""){
            $data = ServiceCate::orderBy('id','DESC')->get();
        }else{
            $data = ServiceCate::where('name', 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->get()->toArray();
        }
        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }
    public function edit($id)
    {
        $data = ServiceCate::where(['id'=>$id])->first();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }
    public function delete( $id)
    {
        $query = ServiceCate::find($id);
        if($query->image != ''){
            $urlimg =  $query->image;
            $this->cloudflareService->deleteImage($urlimg);
        }
        
        $query->delete();
        return response()->json(['message'=>'Delete Success']);
    }
}
