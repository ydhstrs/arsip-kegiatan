<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_no');
            $table->string('guest_name');
            $table->string('guest_job')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('idcard_no')->nullable();
            $table->string('born_place')->nullable();
            $table->integer('duration')->default(0);
            $table->date('birth_date')->nullable();
            $table->date('transaction_date');
            $table->date('checkin_date');
            $table->foreignId('user_id');
            $table->foreignId('room_id');
            $table->decimal('room_price', total: 30, places: 6)->default(0);
            $table->decimal('amount', total: 30, places: 6)->default(0);
            $table->longText('idcard_image')->nullable();
            $table->longText('guest_image')->nullable();
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
        Schema::dropIfExists('checkins');
    }
};
