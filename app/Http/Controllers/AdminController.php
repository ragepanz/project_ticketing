<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\City;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Payment;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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
            ActivityLog::log('login', 'Admin ' . (Auth::user()?->name ?? 'Admin') . ' berhasil login.');
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        ActivityLog::log('logout', 'Admin ' . (Auth::user()?->name ?? 'Admin') . ' logout.');
        $request->session()->forget('admin_logged_in');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('client.login');
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
            'status' => 'nullable|string|in:draft,published,closed,completed',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|mimetypes:image/jpeg,image/png,image/webp|max:4096',
            'image_url' => 'nullable|url|max:2048',
        ]);

        if (empty($validated['status'])) {
            $validated['status'] = Event::STATUS_PUBLISHED;
        }

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = Str::uuid() . '.' . ($file->guessExtension() ?: 'png');
            $validated['image'] = $file->storeAs('events', $filename, 'public');
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->input('image_url');
        }

        $validated['slug'] = Str::slug($validated['title']) . '-' . time();

        $event = Event::create($validated);

        ActivityLog::log(
            'create_event',
            'Admin ' . (Auth::user()?->name ?? 'Admin') . ' membuat event "' . $event->title . '".',
            ['event_id' => $event->id, 'price' => $event->price, 'quota' => $event->quota, 'status' => $event->status]
        );

        Cache::forget('events.published');

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
            'status' => 'nullable|string|in:draft,published,closed,completed',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|mimetypes:image/jpeg,image/png,image/webp|max:4096',
            'image_url' => 'nullable|url|max:2048',
        ]);

        if ($request->hasFile('image_file')) {
            if ($event->image && !filter_var($event->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($event->image);
            }
            $file = $request->file('image_file');
            $filename = Str::uuid() . '.' . ($file->guessExtension() ?: 'png');
            $validated['image'] = $file->storeAs('events', $filename, 'public');
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->input('image_url');
        }

        if (empty($validated['status'])) {
            unset($validated['status']);
        }

        $event->update($validated);

        ActivityLog::log(
            'update_event',
            'Admin ' . (Auth::user()?->name ?? 'Admin') . ' memperbarui event "' . $event->title . '".',
            ['event_id' => $event->id, 'changed_fields' => array_keys($validated)]
        );

        Cache::forget('events.published');

        return redirect()->route('admin.events')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroyEvent(Event $event)
    {
        $title = $event->title;
        $eventId = $event->id;
        $event->delete();

        ActivityLog::log(
            'delete_event',
            'Admin ' . (Auth::user()?->name ?? 'Admin') . ' menghapus event "' . $title . '".',
            ['event_id' => $eventId]
        );

        Cache::forget('events.published');

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

        $now = now();
        $updated = Participant::where('id', $participant->id)
            ->where('checked_in', false)
            ->update([
                'checked_in' => true,
                'checkin_time' => $now,
            ]);

        if ($updated === 0) {
            return response()->json([
                'error' => false,
                'already_checked' => true,
                'participant' => $participant->fresh(),
            ]);
        }

        $participant = $participant->fresh();

        ActivityLog::log(
            'checkin_participant',
            'Admin ' . (Auth::user()?->name ?? 'Admin') . ' melakukan check-in untuk peserta "' . ($participant->name ?? '-') . '" (' . $participant->trx_id . ').',
            ['participant_id' => $participant->id, 'trx_id' => $participant->trx_id, 'event_id' => $participant->event_id]
        );

        return response()->json([
            'error' => false,
            'already_checked' => false,
            'participant' => $participant,
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

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'admin',
        ]);

        ActivityLog::log(
            'create_admin',
            'Superadmin ' . (Auth::user()?->name ?? 'Admin') . ' membuat akun admin "' . $user->name . '" (' . $user->email . ').',
            ['user_id' => $user->id, 'email' => $user->email]
        );

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

        ActivityLog::log(
            'update_admin',
            'Superadmin ' . (Auth::user()?->name ?? 'Admin') . ' memperbarui admin "' . $user->name . '".',
            ['user_id' => $user->id, 'changed_fields' => array_keys($data)]
        );

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

        $name = $user->name;
        $email = $user->email;
        $userId = $user->id;
        $user->delete();

        ActivityLog::log(
            'delete_admin',
            'Superadmin ' . (Auth::user()?->name ?? 'Admin') . ' menghapus akun admin "' . $name . '" (' . $email . ').',
            ['user_id' => $userId]
        );

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

        ActivityLog::log(
            'update_password',
            'User ' . $user->name . ' mengganti password akun.'
        );

        return redirect()->route('admin.dashboard')->with('success', 'Password berhasil diubah.');
    }

    // ==========================================
    // TESTIMONIALS MODERATION MANAGEMENT
    // ==========================================
    public function testimonials()
    {
        $testimonials = Testimonial::latest()->get();
        return view('admin.testimonials', compact('testimonials'));
    }

    public function storeTestimonial(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city_or_event' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'is_featured' => 'nullable|boolean',
        ]);

        Testimonial::create([
            'name' => $validated['name'],
            'city_or_event' => $validated['city_or_event'] ?? 'Peserta Event',
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_featured' => $request->has('is_featured'),
        ]);

        Cache::forget('testimonials.featured');

        return back()->with('success', 'Ulasan berhasil ditambahkan.');
    }

    public function toggleTestimonial(Testimonial $testimonial)
    {
        $testimonial->update([
            'is_featured' => !$testimonial->is_featured,
        ]);

        Cache::forget('testimonials.featured');

        $status = $testimonial->is_featured ? 'ditampilkan di beranda' : 'disembunyikan dari beranda';
        return back()->with('success', 'Status ulasan berhasil diubah: ' . $status . '.');
    }

    public function destroyTestimonial(Testimonial $testimonial)
    {
        $testimonial->delete();
        Cache::forget('testimonials.featured');
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }

    // ==========================================
    // CITIES / REGIONS MANAGEMENT
    // ==========================================
    public function cities()
    {
        $cities = City::orderBy('name', 'asc')->get();
        return view('admin.cities', compact('cities'));
    }

    public function storeCity(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location_name' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:3072',
        ]);

        $imageUrl = '/images/gallery1.png';
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cities', 'public');
            $imageUrl = Storage::url($path);
        }

        City::create([
            'name' => strtoupper($validated['name']),
            'slug' => Str::slug($validated['name']),
            'location_name' => $validated['location_name'] ?? 'Convention Center',
            'image_url' => $imageUrl,
        ]);

        Cache::forget('cities.all');

        return back()->with('success', 'Wilayah / Kota berhasil ditambahkan.');
    }

    public function destroyCity(City $city)
    {
        $city->delete();
        Cache::forget('cities.all');
        return back()->with('success', 'Wilayah / Kota berhasil dihapus.');
    }
}
