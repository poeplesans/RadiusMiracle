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
            $table->id(); // Primary key
            $table->bigInteger('office_id');
            $table->string('invoice')->unique();
            $table->string('item');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->enum('payment', ['unpaid', 'paid', 'partial']);
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->decimal('amount', 15, 2); // Decimal with precision for currency
            $table->decimal('ppn', 5, 2)->nullable(); // Nullable tax (in percent)
            $table->decimal('discount', 5, 2)->nullable(); // Nullable discount (in percent)
            $table->decimal('total', 15, 2); // Final total amount
            $table->timestamps();
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
