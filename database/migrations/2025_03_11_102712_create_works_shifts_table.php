<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('works_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('name_day');
            $table->string('name_shift');
            $table->time('work_start');
            $table->time('work_finish');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('works_shifts');
    }
};
