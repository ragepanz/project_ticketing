<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('trx_id')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('instansi')->nullable();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['lunas', 'pending'])->default('pending');
            $table->boolean('checked_in')->default(false);
            $table->timestamp('checkin_time')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
