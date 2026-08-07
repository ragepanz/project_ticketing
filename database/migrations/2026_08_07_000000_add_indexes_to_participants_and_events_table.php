<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->index('checked_in');
            $table->index('status');
            $table->index('phone');
            $table->index('event_id');
            $table->index('created_at');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->index('date');
            $table->index('created_at');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->index('status');
            $table->index('participant_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropIndex(['checked_in']);
            $table->dropIndex(['status']);
            $table->dropIndex(['phone']);
            $table->dropIndex(['event_id']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['date']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['participant_id']);
            $table->dropIndex(['created_at']);
        });
    }
};
