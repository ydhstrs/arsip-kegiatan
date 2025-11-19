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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->default(1);
            $table->string('transaction_no')->unique();
            $table->string('guest_name');
            $table->date('payment_date')->nullable();
            $table->date('bill_date');
            $table->foreignId('duration')->default(0);
            $table->foreignId('room_id');
            $table->foreignId('checkin_id')->default(0);
            $table->decimal('amount', total: 30, places: 6)->default(0);
            $table->longText('image')->nullable();
            $table->text('remark')->nullable();
            $table->foreignId('created_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
