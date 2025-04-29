<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->string('month_year'); // Format: 'YYYY-MM'
            $table->enum('transaction_type', ['Debit', 'Kredit']);
            $table->text('description');
            $table->decimal('amount', 15, 2); // Menggunakan decimal untuk keuangan
            $table->string('debit_account', 255);
            $table->string('credit_account', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jurnals');
    }
};
