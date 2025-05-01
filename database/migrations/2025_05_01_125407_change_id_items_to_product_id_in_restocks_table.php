<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('restocks', function (Blueprint $table) {
            $table->renameColumn('id_items', 'product_id');
        });
    }

    public function down()
    {
        Schema::table('restocks', function (Blueprint $table) {
            $table->renameColumn('product_id', 'id_items');
        });
    }
};
