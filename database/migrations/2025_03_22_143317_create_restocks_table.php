<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('restocks', function (Blueprint $table) {
            $table->id(); // Kolom Id_Restock (primary key)
            $table->unsignedBigInteger('id_items'); // Kolom Id_Items (foreign key ke tabel inventories)
            $table->integer('restock_amount'); // Kolom Restock_Amount
            $table->timestamp('date'); // Kolom Date (tanggal dan waktu pengajuan)
            $table->string('status'); // Kolom Status (misalnya: "Diajukan", "Diproses", "Selesai")
            $table->timestamps(); // Kolom created_at dan updated_at

            // Foreign key constraint
            $table->foreign('id_items')->references('id')->on('inventories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restocks');
    }
};
