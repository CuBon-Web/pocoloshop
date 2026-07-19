<?php

namespace Tests\Feature;

use App\models\DeviceProduct;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DeviceProductLocationTest extends TestCase
{
    /**
     * Dùng SQLite in-memory để không đụng database MySQL thật.
     */
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
        ]);

        DB::purge('sqlite');
        DB::reconnect('sqlite');
        Schema::connection('sqlite')->defaultStringLength(191);

        Schema::create('device_products', function (Blueprint $table) {
            $table->id();
            $table->string('device_id', 100)->unique();
            $table->string('product_code', 50);
            $table->string('product_serial', 50);
            $table->dateTime('warranty_date');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('location_accuracy', 8, 2)->nullable();
            $table->timestamp('location_captured_at')->nullable();
            $table->timestamps();
        });
    }

    protected function createDeviceProduct(array $overrides = [])
    {
        return DeviceProduct::create(array_merge([
            'device_id' => 'DEV-TEST-001',
            'product_code' => 'PD-TESTCODE',
            'product_serial' => 'SN-TESTSERIAL01',
            'warranty_date' => Carbon::now(),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'PHPUnit',
        ], $overrides));
    }

    public function test_location_validation_requires_valid_coordinates()
    {
        $this->createDeviceProduct();

        $response = $this->postJson('/api/device-product/location', [
            'device_id' => 'DEV-TEST-001',
            'latitude' => 120,
            'longitude' => 200,
            'accuracy' => -1,
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonStructure([
                'errors' => ['latitude', 'longitude', 'accuracy'],
            ]);
    }

    public function test_location_returns_404_when_device_not_found()
    {
        $response = $this->postJson('/api/device-product/location', [
            'device_id' => 'DEV-NOT-FOUND',
            'latitude' => 10.762622,
            'longitude' => 106.660172,
            'accuracy' => 25,
        ]);

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Không tìm thấy thông tin sản phẩm cho thiết bị này',
            ]);
    }

    public function test_location_is_saved_on_first_request()
    {
        $this->createDeviceProduct();

        $response = $this->postJson('/api/device-product/location', [
            'device_id' => 'DEV-TEST-001',
            'latitude' => 10.762622,
            'longitude' => 106.660172,
            'accuracy' => 18.5,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Vị trí thiết bị đã được lưu',
                'data' => [
                    'device_id' => 'DEV-TEST-001',
                    'latitude' => 10.762622,
                    'longitude' => 106.660172,
                    'location_accuracy' => 18.5,
                    'has_location' => true,
                ],
            ]);

        $this->assertDatabaseHas('device_products', [
            'device_id' => 'DEV-TEST-001',
            'latitude' => 10.762622,
            'longitude' => 106.660172,
        ]);
    }

    public function test_location_is_not_overwritten_on_later_requests()
    {
        $this->createDeviceProduct([
            'latitude' => 10.111111,
            'longitude' => 106.222222,
            'location_accuracy' => 10,
            'location_captured_at' => Carbon::now()->subDay(),
        ]);

        $response = $this->postJson('/api/device-product/location', [
            'device_id' => 'DEV-TEST-001',
            'latitude' => 21.028511,
            'longitude' => 105.804817,
            'accuracy' => 99,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Vị trí thiết bị đã được lưu trước đó',
                'data' => [
                    'latitude' => 10.111111,
                    'longitude' => 106.222222,
                    'location_accuracy' => 10.0,
                    'has_location' => true,
                ],
            ]);

        $this->assertDatabaseHas('device_products', [
            'device_id' => 'DEV-TEST-001',
            'latitude' => 10.111111,
            'longitude' => 106.222222,
        ]);
    }

    public function test_get_or_create_returns_saved_location()
    {
        $this->createDeviceProduct([
            'latitude' => 16.047079,
            'longitude' => 108.206230,
            'location_accuracy' => 30,
            'location_captured_at' => Carbon::parse('2026-07-19 08:00:00'),
        ]);

        $response = $this->postJson('/api/device-product/get-or-create', [
            'device_id' => 'DEV-TEST-001',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'device_id' => 'DEV-TEST-001',
                    'latitude' => 16.047079,
                    'longitude' => 108.206230,
                    'location_accuracy' => 30.0,
                    'location_captured_at' => '2026-07-19 08:00:00',
                    'has_location' => true,
                ],
            ]);
    }

    public function test_location_can_be_found_by_product_serial()
    {
        $this->createDeviceProduct([
            'latitude' => 10.762622,
            'longitude' => 106.660172,
            'location_accuracy' => 15,
            'location_captured_at' => Carbon::now(),
        ]);

        $response = $this->postJson('/api/device-product/location-by-serial', [
            'product_serial' => 'sn-testserial01',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'product_serial' => 'SN-TESTSERIAL01',
                    'latitude' => 10.762622,
                    'longitude' => 106.660172,
                    'location_accuracy' => 15.0,
                    'has_location' => true,
                ],
            ]);
    }

    public function test_location_search_returns_404_for_unknown_serial()
    {
        $response = $this->postJson('/api/device-product/location-by-serial', [
            'product_serial' => 'SN-NOT-FOUND',
        ]);

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm với số serial này',
            ]);
    }
}
