<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('logistics', function (Blueprint $table) {
            $table->id();
            $table->string('fleet_number');
            $table->unsignedBigInteger('order_id');
            $table->date('order_date');
            $table->date('estimated_completion_date');
            $table->unsignedBigInteger('mitra_id');
            $table->text('destination_address');
            $table->unsignedBigInteger('product_id');
            $table->decimal('delivered_quantity', 15, 2);
            $table->timestamp('departure_time')->nullable();
            $table->timestamp('delivered_time')->nullable();
            $table->enum('status', ['Dikirim', 'Terkirim Ontime', 'Terkirim Late'])->default('Dikirim');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('mitra_id')->references('id')->on('mitras')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('logistics');
    }
};
