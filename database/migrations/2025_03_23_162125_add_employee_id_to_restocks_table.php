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
        Schema::table('restocks', function (Blueprint $table) {
            // Tambahkan kolom employee_id
            $table->unsignedBigInteger('employee_id')->after('id');

            // Tambahkan foreign key constraint
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restocks', function (Blueprint $table) {
            // Hapus foreign key constraint
            $table->dropForeign(['employee_id']);

            // Hapus kolom employee_id
            $table->dropColumn('employee_id');
        });
    }
};
