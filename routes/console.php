<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $count = \App\Models\Event::where('status', \App\Models\Event::STATUS_PUBLISHED)
        ->whereDate('date', '<', now()->toDateString())
        ->update(['status' => \App\Models\Event::STATUS_CLOSED]);
    
    if ($count > 0) {
        \Illuminate\Support\Facades\Log::info("Auto-closed {$count} expired events");
    }
})->dailyAt('00:05')->name('events.close-expired');

Schedule::call(function () {
    $tomorrow = now()->addDay()->toDateString();
    
    $events = \App\Models\Event::where('status', \App\Models\Event::STATUS_PUBLISHED)
        ->whereDate('date', $tomorrow)
        ->with(['participants' => function ($q) {
            $q->where('status', 'lunas');
        }])
        ->get();
    
    $sent = 0;
    foreach ($events as $event) {
        foreach ($event->participants as $participant) {
            \Illuminate\Support\Facades\Mail::to($participant->email)
                ->send(new \App\Mail\TicketConfirmationMail($participant, $event));
            $sent++;
        }
    }
    
    if ($sent > 0) {
        \Illuminate\Support\Facades\Log::info("Sent {$sent} H-1 reminder emails for events tomorrow");
    }
})->dailyAt('08:00')->name('events.send-reminders');

Schedule::call(function () {
    $count = \App\Models\Event::where('status', \App\Models\Event::STATUS_CLOSED)
        ->whereDate('date', '<=', now()->toDateString())
        ->update(['status' => \App\Models\Event::STATUS_COMPLETED]);
    
    if ($count > 0) {
        \Illuminate\Support\Facades\Log::info("Auto-completed {$count} finished events");
    }
})->dailyAt('00:10')->name('events.auto-complete');

Schedule::call(function () {
    $deleted = \App\Models\Event::onlyTrashed()
        ->where('deleted_at', '<=', now()->subDays(30))
        ->forceDelete();
    
    $deletedParticipants = \App\Models\Participant::onlyTrashed()
        ->where('deleted_at', '<=', now()->subDays(30))
        ->forceDelete();
    
    \Illuminate\Support\Facades\Log::info("Purged {$deleted} events and {$deletedParticipants} participants older than 30 days");
})->weeklyOn(0, '02:00')->name('purge-soft-deletes');
