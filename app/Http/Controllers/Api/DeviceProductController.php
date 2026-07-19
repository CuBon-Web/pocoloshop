<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\DeviceProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Device ID is required',
                'errors' => $validator->errors(),
            ], 400);
        }

        $deviceId = $request->input('device_id');

        // Kiểm tra xem thiết bị đã có thông tin chưa
        $deviceProduct = DeviceProduct::where('device_id', $deviceId)->first();

        if ($deviceProduct) {
            // Nếu đã có, trả về thông tin cũ
            return response()->json([
                'success' => true,
                'data' => $this->formatDeviceProduct($deviceProduct),
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
            'data' => $this->formatDeviceProduct($deviceProduct),
            'message' => 'Thông tin sản phẩm đã được tạo mới'
        ]);
    }

    /**
     * Lấy thông tin sản phẩm theo device_id
     */
    public function getByDeviceId(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Device ID is required',
                'errors' => $validator->errors(),
            ], 400);
        }

        $deviceId = $request->input('device_id');
        $deviceProduct = DeviceProduct::where('device_id', $deviceId)->first();

        if (!$deviceProduct) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin sản phẩm cho thiết bị này'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $this->formatDeviceProduct($deviceProduct)
        ]);
    }

    /**
     * Tìm vị trí sản phẩm theo số serial
     */
    public function getLocationBySerial(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_serial' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập số serial hợp lệ',
                'errors' => $validator->errors(),
            ], 422);
        }

        $productSerial = strtoupper(trim($request->input('product_serial')));
        $deviceProduct = DeviceProduct::where('product_serial', $productSerial)->first();

        if (!$deviceProduct) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm với số serial này',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'product_serial' => $deviceProduct->product_serial,
                'latitude' => $deviceProduct->latitude,
                'longitude' => $deviceProduct->longitude,
                'location_accuracy' => $deviceProduct->location_accuracy,
                'location_captured_at' => $deviceProduct->location_captured_at
                    ? $deviceProduct->location_captured_at->format('Y-m-d H:i:s')
                    : null,
                'has_location' => !is_null($deviceProduct->latitude)
                    && !is_null($deviceProduct->longitude),
            ],
        ]);
    }

    /**
     * Lưu vị trí thiết bị lần đầu (không ghi đè nếu đã có)
     */
    public function saveLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string|max:100',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'accuracy' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu vị trí không hợp lệ',
                'errors' => $validator->errors(),
            ], 422);
        }

        $deviceId = $request->input('device_id');
        $deviceProduct = DeviceProduct::where('device_id', $deviceId)->first();

        if (!$deviceProduct) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin sản phẩm cho thiết bị này'
            ], 404);
        }

        // Đã có vị trí thì trả lại dữ liệu cũ, không ghi đè
        if (!is_null($deviceProduct->latitude) && !is_null($deviceProduct->longitude)) {
            return response()->json([
                'success' => true,
                'data' => $this->formatDeviceProduct($deviceProduct),
                'message' => 'Vị trí thiết bị đã được lưu trước đó'
            ]);
        }

        $capturedAt = Carbon::now();
        $accuracy = $request->input('accuracy');

        // Cập nhật có điều kiện để tránh race condition ghi đè vị trí lần đầu
        $updated = DeviceProduct::where('id', $deviceProduct->id)
            ->whereNull('latitude')
            ->whereNull('longitude')
            ->update([
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'location_accuracy' => $accuracy,
                'location_captured_at' => $capturedAt,
            ]);

        $deviceProduct->refresh();

        return response()->json([
            'success' => true,
            'data' => $this->formatDeviceProduct($deviceProduct),
            'message' => $updated
                ? 'Vị trí thiết bị đã được lưu'
                : 'Vị trí thiết bị đã được lưu trước đó'
        ]);
    }

    /**
     * Chuẩn hóa dữ liệu trả về client
     */
    protected function formatDeviceProduct(DeviceProduct $deviceProduct)
    {
        return [
            'device_id' => $deviceProduct->device_id,
            'product_code' => $deviceProduct->product_code,
            'product_serial' => $deviceProduct->product_serial,
            'warranty_date' => $deviceProduct->warranty_date
                ? $deviceProduct->warranty_date->format('Y-m-d H:i:s')
                : null,
            'warranty_date_formatted' => $deviceProduct->warranty_date
                ? $deviceProduct->warranty_date->format('d/m/Y H:i')
                : null,
            'latitude' => $deviceProduct->latitude,
            'longitude' => $deviceProduct->longitude,
            'location_accuracy' => $deviceProduct->location_accuracy,
            'location_captured_at' => $deviceProduct->location_captured_at
                ? $deviceProduct->location_captured_at->format('Y-m-d H:i:s')
                : null,
            'has_location' => !is_null($deviceProduct->latitude) && !is_null($deviceProduct->longitude),
        ];
    }
}
