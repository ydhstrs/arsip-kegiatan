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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('title');
            $table->string('desc')->nullable();
            $table->longText('file1')->nullable();
            $table->longText('file2')->nullable();
            $table->longText('video')->nullable();
            $table->text('remark')->nullable();
            $table->string('status');
            $table->string('remark_kasi')->nullable();
            $table->string('remark_kabid')->nullable();
            $table->foreignId('user_id')->default(0);
            $table->foreignId('letter_id')->default(0);
            $table->foreignId('kasi_user_id')->default(0);
            $table->foreignId('kasi_approved_by')->default(0);
            $table->foreignId('kasat_user_id')->default(0);
            $table->foreignId('kabid_user_id')->default(0);
            $table->foreignId('staff_user_id')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
