<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class CloudflareImageService
{
    protected $apiToken;
    protected $accountId;

    public function __construct()
    {
        $this->apiToken = env('CLOUDFLARE_IMAGES_API_TOKEN');
        $this->accountId = env('CLOUDFLARE_ACCOUNT_ID');
    }

    /**
     * Upload ảnh lên Cloudflare Images
     */
    public function uploadImage($image)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken
        ])->attach(
            'file', file_get_contents($image), $image->getClientOriginalName()
        )->post("https://api.cloudflare.com/client/v4/accounts/{$this->accountId}/images/v1");

       

        return $response->json();
    }

    /**
     * Xóa ảnh trên Cloudflare Images
     */
    public function deleteImage($imageId)
    {
        $pattern = '/imagedelivery\.net\/[^\/]+\/([a-f0-9\-]+)\/public/';
        $getId = preg_match($pattern, $imageId, $matches);
        $id = $matches[1];
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken
        ])->delete("https://api.cloudflare.com/client/v4/accounts/{$this->accountId}/images/v1/{$id}");

        // $response = Http::withHeaders([
        //     'Authorization' => 'Bearer ' . $this->apiToken
        // ])->delete("https://api.cloudflare.com/client/v4/accounts/{$this->accountId}/images/v1/{$imageId}");

        return $response->json();
    }
}
