<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->date('order_date');
            $table->date('estimated_completion_date');
            $table->unsignedBigInteger('mitra_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('quantity', 15, 2);
            $table->decimal('total_price', 15, 2);
            $table->enum('status', ['Dibuat', 'Diproses', 'Terkirim Ontime', 'Terkirim Late', 'Ditolak'])->default('Dibuat');
            $table->decimal('remaining_quantity', 15, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('mitra_id')->references('id')->on('mitras')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
