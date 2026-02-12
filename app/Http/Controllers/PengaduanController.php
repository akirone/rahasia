<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        // Get all categories for filter
        $kategoris = Kategori::all();

        // Build query
        $query = Pengaduan::with(['user', 'kategori', 'feedback']);

        // If not admin, only show user's own pengaduan
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter by student (admin only)
        if ($request->filled('siswa') && $user->isAdmin()) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->siswa . '%')
                    ->orWhere('nis', 'like', '%' . $request->siswa . '%');
            });
        }

        // Filter by month
        if ($request->filled('bulan')) {
            $bulan = $request->bulan; // Format: YYYY-MM
            $query->whereYear('tanggal', substr($bulan, 0, 4))
                ->whereMonth('tanggal', substr($bulan, 5, 2));
        }

        // Filter by date range
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal', '<=', $request->sampai_tanggal);
        }

        // Search in location or description
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('lokasi', 'like', '%' . $request->search . '%')
                    ->orWhere('keterangan', 'like', '%' . $request->search . '%');
            });
        }

        // Order by newest first
        $query->orderBy('created_at', 'desc');

        // Paginate results
        $pengaduans = $query->paginate(10)->appends($request->query());

        return view('pengaduan.index', compact('pengaduans', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Admin tidak bisa membuat pengaduan (hanya siswa/user yang bisa)
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('pengaduan.index')
                ->with('error', 'Admin tidak dapat membuat pengaduan. Hanya siswa yang dapat membuat pengaduan.');
        }

        $kategoris = Kategori::all();
        return view('pengaduan.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Admin tidak bisa membuat pengaduan (hanya siswa/user yang bisa)
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('pengaduan.index')
                ->with('error', 'Admin tidak dapat membuat pengaduan.');
        }

        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi' => 'required|string|max:45',
            'keterangan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ], [
            'kategori_id.required' => 'Kategori wajib dipilih',
            'kategori_id.exists' => 'Kategori tidak valid',
            'lokasi.required' => 'Lokasi wajib diisi',
            'lokasi.max' => 'Lokasi maksimal 45 karakter',
            'keterangan.required' => 'Keterangan wajib diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',
            'foto.max' => 'Ukuran gambar maksimal 2MB'
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('pengaduan', $filename, 'public');
            $validated['foto'] = $path;
        }

        // Add additional data
        $validated['user_id'] = Auth::id();
        $validated['tanggal'] = now();
        $validated['status'] = 'Menunggu';

        Pengaduan::create($validated);

        // Redirect to dashboard with success message
        return redirect()->route('dashboard')
            ->with('success', '🎉 Pengaduan berhasil dikirim! Admin akan segera meninjau dan menindaklanjuti pengaduan Anda.');
    }

    public function show(Pengaduan $pengaduan)
    {
        // Check authorization - user can only see their own pengaduan, admin can see all
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isAdmin() && $pengaduan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pengaduan ini');
        }

        // Load relationships
        $pengaduan->load(['user', 'kategori', 'feedback.user']);
        $kategoris = Kategori::all();

        return view('pengaduan.show', compact('pengaduan', 'kategoris'));
    }

    public function edit(Pengaduan $pengaduan)
    {
        // Check authorization - only owner can edit
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($pengaduan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah pengaduan ini');
        }

        // Only allow editing if status is still 'Menunggu'
        if ($pengaduan->status !== 'Menunggu') {
            return redirect()->route('pengaduan.show', $pengaduan)
                ->with('error', 'Pengaduan yang sudah diproses tidak dapat diubah');
        }

        $kategoris = Kategori::all();
        return view('pengaduan.edit', compact('pengaduan', 'kategoris'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        // Check authorization - only owner can update (and only if status is Menunggu)
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($pengaduan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah pengaduan ini');
        }

        if ($pengaduan->status !== 'Menunggu') {
            return redirect()->route($user->isAdmin() ? 'pengaduan.index' : 'dashboard')
                ->with('error', 'Pengaduan yang sudah diproses tidak dapat diubah');
        }

        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi' => 'required|string|max:45',
            'keterangan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:4096'
        ], [
            'kategori_id.required' => 'Kategori wajib dipilih',
            'kategori_id.exists' => 'Kategori tidak valid',
            'lokasi.required' => 'Lokasi wajib diisi',
            'lokasi.max' => 'Lokasi maksimal 45 karakter',
            'keterangan.required' => 'Keterangan wajib diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',
            'foto.max' => 'Ukuran gambar maksimal 4MB'
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($pengaduan->foto) {
                Storage::disk('public')->delete($pengaduan->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('pengaduan', $filename, 'public');
            $validated['foto'] = $path;
        }

        $pengaduan->update($validated);

        return redirect()->route('dashboard')
            ->with('success', '✅ Pengaduan berhasil diperbarui! Perubahan Anda telah disimpan.');
    }

    public function destroy(Pengaduan $pengaduan)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($pengaduan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus pengaduan ini');
        }

        if ($pengaduan->status !== 'Menunggu') {
            return redirect()->route($user->isAdmin() ? 'pengaduan.index' : 'dashboard')
                ->with('error', 'Pengaduan yang sudah diproses tidak dapat dihapus');
        }

        // Delete photo if exists
        if ($pengaduan->foto) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        $pengaduan->delete();

        return redirect()->route('dashboard')
            ->with('success', '🗑️ Pengaduan berhasil dihapus dari sistem.');
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $validated = $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai',
            'foto_dokumentasi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096'
        ], [
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid. Pilih: Menunggu, Proses, atau Selesai',
            'foto_dokumentasi.image' => 'File harus berupa gambar',
            'foto_dokumentasi.mimes' => 'Format gambar harus: jpeg, png, jpg, atau gif',
            'foto_dokumentasi.max' => 'Ukuran gambar maksimal 4MB',
        ]);

        // Handle foto dokumentasi upload
        if ($request->hasFile('foto_dokumentasi')) {
            // Delete old foto dokumentasi if exists
            if ($pengaduan->foto_dokumentasi) {
                Storage::delete($pengaduan->foto_dokumentasi);
            }

            $validated['foto_dokumentasi'] = $request->file('foto_dokumentasi')->store('dokumentasi', 'public');
        }

        $pengaduan->update($validated);

        return redirect()->route('pengaduan.show', $pengaduan)
            ->with('success', 'Status pengaduan berhasil diperbarui');
    }
}
