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
        Schema::create('payings', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_no')->unique();
            $table->string('name');
            $table->date('transaction_date');
            $table->decimal('amount', total: 30, places: 6)->default(0);
            $table->longText( 'image')->nullable();
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
        Schema::dropIfExists('payings');
    }
};
