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
        Schema::create('customer_responses', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_number');
            $table->longText('remarks');
            $table->string('date');
            $table->foreignId('agent')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_responses');
    }
};
