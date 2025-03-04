<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_request_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('service_request_id')->unsigned()->nullable();
            $table->foreign('service_request_id')->references('id')->on('service_requests')->onDelete('cascade');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->bigInteger('service_id')->unsigned()->nullable();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->string('quantity')->nullable();
            $table->boolean('status')->default(1);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_request_products');
    }
};
