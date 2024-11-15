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
        Schema::create('customers', function (Blueprint $table) {
              $table->id();  // Auto-incrementing primary key
              $table->string('customer_name');
              $table->string('customer_email')->default('No Email');
              $table->string('customer_number')->unique();
              $table->decimal('price', 8, 2);  // Adjust size based on your needs
              $table->text('remarks');
              $table->string('status');
              $table->string('a_name');  // Admin name or associated user
            // $table->unsignedBigInteger('user_id');  // Foreign key for users
              $table->timestamps();  // Created at / Updated at columns

        // If you have a users table, add a foreign key
        // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
