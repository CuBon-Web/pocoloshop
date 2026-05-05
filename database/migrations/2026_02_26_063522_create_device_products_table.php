<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_products', function (Blueprint $table) {
            $table->id();
            $table->string('device_id', 100)->unique()->comment('Mã định danh thiết bị duy nhất');
            $table->string('product_code', 50)->comment('Mã sản phẩm');
            $table->string('product_serial', 50)->comment('Số seri sản phẩm');
            $table->datetime('warranty_date')->comment('Thời gian bảo hành (thời điểm kích hoạt)');
            $table->string('ip_address', 45)->nullable()->comment('Địa chỉ IP');
            $table->text('user_agent')->nullable()->comment('User Agent của trình duyệt');
            $table->timestamps();
            
            $table->index('device_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_products');
    }
}
