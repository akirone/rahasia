<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Admin Dashboard
            $data = [
                'totalPengaduan' => Pengaduan::count(),
                'menunggu' => Pengaduan::where('status', 'Menunggu')->count(),
                'proses' => Pengaduan::where('status', 'Proses')->count(),
                'selesai' => Pengaduan::where('status', 'Selesai')->count(),
                'totalKategori' => Kategori::count(),
                'totalUser' => User::where('is_admin', false)->count(),
                'recentPengaduan' => Pengaduan::with(['user', 'kategori'])
                    ->latest()
                    ->take(10)
                    ->get(),
                'users' => User::withCount('pengaduans')->latest()->paginate(5),
            ];

            return view('dashboard.admin', $data);
        } else {
            // User Dashboard
            $data = [
                'totalPengaduan' => Pengaduan::where('user_id', $user->id)->count(),
                'menunggu' => Pengaduan::where('user_id', $user->id)->where('status', 'Menunggu')->count(),
                'proses' => Pengaduan::where('user_id', $user->id)->where('status', 'Proses')->count(),
                'selesai' => Pengaduan::where('user_id', $user->id)->where('status', 'Selesai')->count(),
                'recentPengaduan' => Pengaduan::with(['kategori', 'feedback'])
                    ->where('user_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get(),
                'kategoris' => Kategori::all(),
            ];

            return view('dashboard.user', $data);
        }
    }
}
