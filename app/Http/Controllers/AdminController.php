<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'role' => 'admin'])
            || Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'role' => 'superadmin'])) {
            $request->session()->regenerate();
            $request->session()->put('admin_logged_in', true);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_logged_in');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $events = Event::withCount('participants')->get();
        $totalPeserta = Participant::count();
        $totalHadir = Participant::where('checked_in', true)->count();
        $totalBelum = $totalPeserta - $totalHadir;
        $checkinPercent = $totalPeserta > 0 ? round(($totalHadir / $totalPeserta) * 100) : 0;

        $recentParticipants = Participant::with('event')->latest()->take(10)->get();
        
        $totalRevenue = Payment::where('status', 'lunas')->sum('amount');

        return view('admin.dashboard', compact('events', 'totalPeserta', 'totalHadir', 'totalBelum', 'checkinPercent', 'recentParticipants', 'totalRevenue'));
    }

    public function events()
    {
        $events = Event::withCount('participants')->get();
        return view('admin.events', compact('events'));
    }

    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'speaker' => 'nullable|string|max:255',
            'time_slot' => 'nullable|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'quota' => 'required|integer|min:1',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'image_url' => 'nullable|string',
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image'] = $request->file('image_file')->store('events', 'public');
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->input('image_url');
        }

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']) . '-' . time();

        Event::create($validated);

        return redirect()->route('admin.events')->with('success', 'Event berhasil ditambahkan.');
    }

    public function updateEvent(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'speaker' => 'nullable|string|max:255',
            'time_slot' => 'nullable|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'quota' => 'required|integer|min:1',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'image_url' => 'nullable|string',
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image'] = $request->file('image_file')->store('events', 'public');
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->input('image_url');
        }

        $event->update($validated);

        return redirect()->route('admin.events')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroyEvent(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events')->with('success', 'Event berhasil dihapus.');
    }

    public function participants(Request $request)
    {
        $search = $request->get('search');
        $query = Participant::with('event');

        if ($search) {
            $safe = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search);
            $query->where(function ($q) use ($safe) {
                $q->where('name', 'like', "%{$safe}%")
                  ->orWhere('trx_id', 'like', "%{$safe}%")
                  ->orWhere('email', 'like', "%{$safe}%");
            });
        }

        $participants = $query->latest()->paginate(20);

        return view('admin.participants', compact('participants', 'search'));
    }

    public function scan()
    {
        return view('admin.scan');
    }

    public function processScan(Request $request)
    {
        $code = $request->input('code');
        $participant = Participant::with('event')->where('trx_id', $code)->first();

        if (!$participant) {
            return response()->json(['error' => true, 'message' => 'Tiket tidak ditemukan.']);
        }

        if ($participant->checked_in) {
            return response()->json([
                'error' => false,
                'already_checked' => true,
                'participant' => $participant,
            ]);
        }

        $participant->update([
            'checked_in' => true,
            'checkin_time' => now(),
        ]);

        return response()->json([
            'error' => false,
            'already_checked' => false,
            'participant' => $participant->fresh(),
        ]);
    }

    public function reports()
    {
        $events = Event::with('participants')->get();
        $totalPeserta = Participant::count();
        $totalHadir = Participant::where('checked_in', true)->count();
        $totalBelum = $totalPeserta - $totalHadir;
        $lunas = Payment::where('status', 'lunas')->count();
        $pending = $totalPeserta - $lunas;

        return view('admin.reports', compact('events', 'totalPeserta', 'totalHadir', 'totalBelum', 'lunas', 'pending'));
    }

    public function exportCsv()
    {
        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama', 'Email', 'WhatsApp', 'Instansi', 'Event', 'Kode Tiket', 'Status Bayar', 'Check-in', 'Waktu Check-in']);

            Participant::with('event')->chunk(200, function ($participants) use ($file) {
                foreach ($participants as $p) {
                    fputcsv($file, [
                        $p->name,
                        $p->email,
                        $p->phone,
                        $p->instansi ?? '-',
                        $p->event->title ?? '-',
                        $p->trx_id,
                        $p->status,
                        $p->checked_in ? 'Hadir' : 'Belum',
                        $p->checkin_time ? $p->checkin_time->format('d M Y, H:i') : '-',
                    ]);
                }
            });

            fclose($file);
        };

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="data-peserta.csv"',
        ];

        return response()->stream($callback, 200, $headers);
    }

    public function users()
    {
        $users = User::whereIn('role', ['superadmin', 'admin'])->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }
        return view('admin.user-form');
    }

    public function storeUser(Request $request)
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'admin',
        ]);

        return redirect()->route('admin.users')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function editUser(User $user)
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }
        if ($user->role === 'superadmin') {
            abort(403, 'Tidak dapat mengedit superadmin lain.');
        }
        return view('admin.user-form', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }
        if ($user->role === 'superadmin') {
            abort(403, 'Tidak dapat mengedit superadmin lain.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if ($request->filled('password')) {
            $data['password'] = $validated['password'];
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroyUser(User $user)
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }
        if ($user->role === 'superadmin') {
            abort(403, 'Tidak dapat menghapus superadmin.');
        }

        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'Tidak dapat menghapus akun sendiri.']);
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Admin berhasil dihapus.');
    }

    public function passwordForm()
    {
        return view('admin.password');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!\Illuminate\Support\Facades\Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->update(['password' => $validated['new_password']]);

        return redirect()->route('admin.dashboard')->with('success', 'Password berhasil diubah.');
    }
}
