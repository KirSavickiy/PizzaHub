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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->enum('delivery_method', ['pickup', 'delivery']);
            $table->enum('payment_method', ['cash', 'card', 'online']);
            $table->dateTime('delivery_time');
            $table->decimal('total_price', 10, 2);
            $table->foreignId('address_id')->nullable()->constrained('addresses');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
