<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    public function processScan(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = $request->input('code');
        $participant = Participant::with('event')->where('trx_id', $code)->first();

        if (!$participant) {
            return response()->json([
                'success' => false,
                'error' => 'Tiket tidak ditemukan.',
                'message' => 'Kode tiket ' . $code . ' tidak valid atau tidak terdaftar.',
            ], 404);
        }

        $now = now();
        $updated = Participant::where('id', $participant->id)
            ->where('checked_in', false)
            ->update([
                'checked_in' => true,
                'checkin_time' => $now,
            ]);

        if ($updated === 0) {
            return response()->json([
                'success' => false,
                'error' => 'already_checked_in',
                'message' => 'Tiket ini sudah di-check-in sebelumnya.',
                'participant' => [
                    'id' => $participant->id,
                    'name' => $participant->name,
                    'email' => $participant->email,
                    'trx_id' => $participant->trx_id,
                    'event_title' => $participant->event->title,
                    'checked_in_at' => $participant->checkin_time?->format('Y-m-d H:i:s'),
                ],
            ], 400);
        }

        $participant = $participant->fresh();

        ActivityLog::log(
            'checkin_participant_api',
            'Admin ' . (Auth::user()?->name ?? 'Admin') . ' melakukan check-in via API untuk peserta "' . ($participant->name ?? '-') . '" (' . $participant->trx_id . ').',
            ['participant_id' => $participant->id, 'trx_id' => $participant->trx_id, 'event_id' => $participant->event_id]
        );

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil.',
            'participant' => [
                'id' => $participant->id,
                'name' => $participant->name,
                'email' => $participant->email,
                'phone' => $participant->phone,
                'instansi' => $participant->instansi,
                'trx_id' => $participant->trx_id,
                'event_title' => $participant->event->title,
                'event_date' => $participant->event->date->format('Y-m-d'),
                'event_location' => $participant->event->location,
                'checked_in_at' => $participant->checkin_time->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
