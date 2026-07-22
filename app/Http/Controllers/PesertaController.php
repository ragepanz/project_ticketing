<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('peserta.index', compact('events'));
    }

    public function detail(Event $event)
    {
        return view('peserta.detail', compact('event'));
    }

    public function form(Request $request, Event $event)
    {
        return view('peserta.form', compact('event'));
    }

    public function review(Request $request, Event $event)
    {
        $data = $request->session()->get('peserta_form');
        if (!$data) {
            return redirect()->route('peserta.form', $event);
        }
        return view('peserta.review', compact('event', 'data'));
    }

    public function storeForm(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'instansi' => 'nullable|string|max:255',
        ]);

        $request->session()->put('peserta_form', $validated);
        $request->session()->put('peserta_event_id', $event->id);

        return redirect()->route('peserta.review', $event);
    }

    public function payment(Request $request, Event $event)
    {
        $data = $request->session()->get('peserta_form');
        if (!$data) {
            return redirect()->route('peserta.form', $event);
        }
        return view('peserta.payment', compact('event', 'data'));
    }

    public function confirm(Request $request, Event $event)
    {
        $data = $request->session()->get('peserta_form');
        if (!$data) {
            return redirect()->route('peserta.form', $event);
        }

        $registeredCount = Participant::where('event_id', $event->id)
            ->where('status', 'lunas')
            ->count();
        if ($registeredCount >= $event->quota) {
            return redirect()->route('peserta.detail', $event)
                ->with('error', 'Maaf, kuota event ini sudah penuh.');
        }

        $trxId = 'TRX-' . strtoupper(substr(uniqid(), -5));

        $participant = Participant::create([
            'trx_id' => $trxId,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'instansi' => $data['instansi'] ?? null,
            'event_id' => $event->id,
            'status' => 'lunas',
            'checked_in' => false,
        ]);

        $participant->payments()->create([
            'amount' => $event->price,
            'status' => 'lunas',
            'payment_date' => now(),
        ]);

        $request->session()->forget(['peserta_form', 'peserta_event_id']);
        $request->session()->put('ticket_trx_id', $trxId);
        $request->session()->put('ticket_event_id', $event->id);

        return redirect()->route('peserta.ticket', $event);
    }

    public function ticket(Request $request, Event $event)
    {
        $trxId = $request->session()->get('ticket_trx_id');
        $participant = Participant::where('trx_id', $trxId)->first();

        if (!$participant || $participant->event_id != $event->id) {
            return redirect()->route('peserta.index');
        }

        return view('peserta.ticket', compact('event', 'participant'));
    }

    public function searchOrder()
    {
        return view('peserta.search');
    }

    public function findOrder(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
        ]);

        $q = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], trim($request->input('query')));

        $participant = Participant::where('trx_id', 'LIKE', "%{$q}%")
            ->orWhere('email', 'LIKE', "%{$q}%")
            ->orWhere('phone', 'LIKE', "%{$q}%")
            ->first();

        if (!$participant) {
            return back()->with('error', 'Pesanan tidak ditemukan dengan Kode TRX / Email / WhatsApp tersebut.');
        }

        $request->session()->put('ticket_trx_id', $participant->trx_id);
        $request->session()->put('ticket_event_id', $participant->event_id);

        return redirect()->route('peserta.ticket', $participant->event_id);
    }
}
