<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('department');
            $table->string('position');
            $table->string('manager')->nullable();
            $table->string('employee_type');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('ktp_address');
            $table->string('ktp_city');
            $table->string('domicile_address');
            $table->string('domicile_city');
            $table->string('bank_account');
            $table->decimal('net_salary', 10, 2);
            $table->string('nationality');
            $table->string('ktp_number');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('marital_status');
            $table->string('spouse_complete_name')->nullable();
            $table->integer('number_of_dependent_children')->default(0);
            $table->string('educational_level');
            $table->string('field_of_study');
            $table->string('school');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
