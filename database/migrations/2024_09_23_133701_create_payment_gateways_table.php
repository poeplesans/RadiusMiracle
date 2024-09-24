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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id(); // auto-increment big integer
            $table->string('name'); // Name of the payment gateway
            $table->text('url_endpoint'); // Endpoint URL for the gateway
            $table->string('merchant_id'); // Merchant ID
            $table->string('client_key'); // Client key for the gateway
            $table->string('server_key'); // Server key for the gateway
            $table->boolean('status')->default(true); // Status (active or inactive)
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_getways');
    }
};
