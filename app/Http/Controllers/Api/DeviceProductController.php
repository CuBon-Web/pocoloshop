<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\DeviceProduct;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DeviceProductController extends Controller
{
    /**
     * Lấy hoặc tạo thông tin sản phẩm cho thiết bị
     * Nếu thiết bị chưa có thông tin, tạo mới
     * Nếu đã có, trả về thông tin cũ
     */
    public function getOrCreate(Request $request)
    {
        $deviceId = $request->input('device_id');
        
        if (!$deviceId) {
            return response()->json([
                'success' => false,
                'message' => 'Device ID is required'
            ], 400);
        }

        // Kiểm tra xem thiết bị đã có thông tin chưa
        $deviceProduct = DeviceProduct::where('device_id', $deviceId)->first();

        if ($deviceProduct) {
            // Nếu đã có, trả về thông tin cũ
            return response()->json([
                'success' => true,
                'data' => [
                    'device_id' => $deviceProduct->device_id,
                    'product_code' => $deviceProduct->product_code,
                    'product_serial' => $deviceProduct->product_serial,
                    'warranty_date' => $deviceProduct->warranty_date->format('Y-m-d H:i:s'),
                    'warranty_date_formatted' => $deviceProduct->warranty_date->format('d/m/Y H:i'),
                ],
                'message' => 'Thông tin sản phẩm đã tồn tại'
            ]);
        }

        // Nếu chưa có, tạo mới
        $productCode = 'PD-' . strtoupper(Str::random(8));
        $productSerial = 'SN-' . strtoupper(Str::random(12));
        $warrantyDate = Carbon::now();

        $deviceProduct = DeviceProduct::create([
            'device_id' => $deviceId,
            'product_code' => $productCode,
            'product_serial' => $productSerial,
            'warranty_date' => $warrantyDate,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'device_id' => $deviceProduct->device_id,
                'product_code' => $deviceProduct->product_code,
                'product_serial' => $deviceProduct->product_serial,
                'warranty_date' => $deviceProduct->warranty_date->format('Y-m-d H:i:s'),
                'warranty_date_formatted' => $deviceProduct->warranty_date->format('d/m/Y H:i'),
            ],
            'message' => 'Thông tin sản phẩm đã được tạo mới'
        ]);
    }

    /**
     * Lấy thông tin sản phẩm theo device_id
     */
    public function getByDeviceId(Request $request)
    {
        $deviceId = $request->input('device_id');
        
        if (!$deviceId) {
            return response()->json([
                'success' => false,
                'message' => 'Device ID is required'
            ], 400);
        }

        $deviceProduct = DeviceProduct::where('device_id', $deviceId)->first();

        if (!$deviceProduct) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin sản phẩm cho thiết bị này'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'device_id' => $deviceProduct->device_id,
                'product_code' => $deviceProduct->product_code,
                'product_serial' => $deviceProduct->product_serial,
                'warranty_date' => $deviceProduct->warranty_date->format('Y-m-d H:i:s'),
                'warranty_date_formatted' => $deviceProduct->warranty_date->format('d/m/Y H:i'),
            ]
        ]);
    }
}
