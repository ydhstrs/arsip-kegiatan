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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('no')->unique();
            $table->text('desc')->nullable();
            $table->longText('file')->nullable();
            $table->string('source')->nullable();
            $table->text('remark')->nullable();
            $table->string('status');
            $table->text('remark_kasi')->nullable();
            $table->text('remark_kabid')->nullable();
            $table->foreignId('kabid_user_id')->default(0);
            $table->timestamp('kabid_edited_at')->nullable();
            $table->foreignId('kasi_user_id')->default(0);
            $table->timestamp('kasi_edited_at')->nullable();
            $table->foreignId('staff_user_id')->default(0);
            $table->timestamp('staff_edited_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
