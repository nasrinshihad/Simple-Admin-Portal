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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id'); 
            $table->date('date'); 
            $table->decimal('amount', 10, 2); 
            $table->enum('status', ['unpaid', 'paid', 'cancelled'])->default('unpaid');
            $table->timestamps(); 

            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
