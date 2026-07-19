<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationColumnsToDeviceProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_products', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable()->after('user_agent')->comment('Vĩ độ thiết bị');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude')->comment('Kinh độ thiết bị');
            $table->decimal('location_accuracy', 8, 2)->nullable()->after('longitude')->comment('Độ chính xác vị trí (mét)');
            $table->timestamp('location_captured_at')->nullable()->after('location_accuracy')->comment('Thời điểm lưu vị trí lần đầu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device_products', function (Blueprint $table) {
            $table->dropColumn([
                'latitude',
                'longitude',
                'location_accuracy',
                'location_captured_at',
            ]);
        });
    }
}
