<?php

namespace App\Http\Controllers\Api\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\blog\Blog;
use App\Services\CloudflareImageService;

class BlogController extends Controller
{
    protected $apiToken;
    protected $accountId;
    protected $cloudflareService;

    public function __construct(CloudflareImageService $cloudflareService)
    {
        $this->cloudflareService = $cloudflareService;
    }
    public function create(Request $request, Blog $blog)
    {
    	$data = $blog->saveBlog($request);
        return response()->json([
    		'message' => 'Save Success',
    		'data'=> $data
    	],200);
    }
    public function list(Request $request)
    {
    	$keyword = $request->keyword;
        if($keyword == ""){
            $data = Blog::with([
                'cate' => function ($query) {
                    $query->select('id','name','slug'); 
                }, 
                'typeCate' => function ($query) {
                    $query->select('id','name','slug'); 
                }
            ])->orderBy('id','DESC')->get(['id','title','created_at','category','type_cate','type_news']);
        }else{
            $data = Blog::where('title', 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->get()->toArray();
        }
        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }
    public function delete($id)
    {
        $query = Blog::find($id);
        if($query->image != ''){
            $urlimg =  $query->image;
            $this->cloudflareService->deleteImage($urlimg);
        }
        $query->delete();
        return response()->json(['message'=>'Delete Success'],200);
    }
    public function edit($id)
    {
        $data = Blog::where([
            'id'=> $id
        ])
        ->first();
        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }

}
