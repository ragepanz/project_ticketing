<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('speaker')->nullable();
            $table->string('time_slot')->nullable();
            $table->string('image')->nullable();
            $table->date('date');
            $table->string('location');
            $table->text('desc');
            $table->integer('price');
            $table->integer('quota');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
