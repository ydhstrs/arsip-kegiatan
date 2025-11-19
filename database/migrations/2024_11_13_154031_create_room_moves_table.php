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
        Schema::create('room_moves', function (Blueprint $table) {
            $table->id();
            $table->string('guest_name');
            $table->foreignId('from_room_id');
            $table->foreignId('to_room_id');
            $table->date('move_date');
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
        Schema::dropIfExists('room_moves');
    }
};
