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
        Schema::table('orders', function (Blueprint $table) {
            
            $table->string('bill_no')->after('invoiceno')->nullable();
            $table->string('ordertype')->after('salestype')->nullable();
            $table->bigInteger('service_request_id')->after('customer_id')->unsigned()->nullable();
            $table->foreign('service_request_id')->references('id')->on('service_requests')->onDelete('cascade');
            $table->boolean('reduceqty')->after('partnoshow')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
