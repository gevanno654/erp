<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->string('salary_id', 20)->unique(); // Format: GBK10100001
            $table->date('date');
            $table->string('month_year', 7); // Format: YYYY-MM
            $table->unsignedBigInteger('employee_id');
            $table->integer('attendance_count')->default(0);
            $table->decimal('incentive', 15, 2)->default(0);
            $table->decimal('total_salary', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('salaries');
    }
};
