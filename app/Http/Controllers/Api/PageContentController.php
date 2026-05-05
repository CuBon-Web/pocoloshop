<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\PageContent;
use App\Services\CloudflareImageService;

class PageContentController extends Controller
{
    protected $apiToken;
    protected $accountId;
    protected $cloudflareService;

    public function __construct(CloudflareImageService $cloudflareService)
    {
        $this->cloudflareService = $cloudflareService;
    }
    public function create(Request $request,PageContent $page_content)
    {
        $page_content->savePageContent($request);
        return response()->json([
            'message' => 'Success'
        ]);
    }
    public function list(Request $request)
    {
    	$keyword = $request->keyword;
        if($keyword == ""){
            $data = PageContent::orderBy('id','DESC')->where('language','vi')->get();
        }else{
            $data = PageContent::where('title', 'LIKE', '%'.$keyword.'%')->where('language','vi')->orderBy('id','DESC')->get()->toArray();
        }
        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }
    public function edit($quiz_id, $language)
    {
    	$data = PageContent::where([
            'quiz_id'=> $quiz_id,
            'language' => $language
        ])
        ->first();
        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }
    public function deletePageContent($quiz_id)
    {
        $query = PageContent::where('quiz_id',$quiz_id)->get();
        
        // foreach($query as $item){
        //     $data = PageContent::find($item->id);
        //     $arrimg = json_decode($data->image);
        //         foreach($arrimg as $url){
        //             $this->cloudflareService->deleteImage($url);
        //         }
        //     $data->delete();
        // }
        return response()->json([
            'message' => 'success'
        ]);
    }
}
