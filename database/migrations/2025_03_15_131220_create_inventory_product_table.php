<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventory_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('stock_amount')->default(0);
            $table->timestamp('updated_stock_date')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // Unique constraint untuk mencegah duplikasi data
            $table->unique(['inventory_id', 'product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_product');
    }
};
