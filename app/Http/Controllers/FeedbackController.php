<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Feedback;
use App\Models\Pengaduan;

class FeedbackController extends Controller
{
    public function store(Request $request, Pengaduan $pengaduan)
    {
        $validated = $request->validate([
            'isi' => 'required|string',
        ], [
            'isi.required' => 'Feedback wajib diisi',
            'isi.string' => 'Feedback harus berupa teks',
        ]);

        $validated['pengaduan_id'] = $pengaduan->id;
        $validated['user_id'] = Auth::id();
        $validated['tanggal'] = now();

        Feedback::create($validated);

        if ($pengaduan->status === 'Menunggu') {
            $pengaduan->update(['status' => 'Proses']);
        }

        return redirect()->back()
            ->with('success', 'Feedback berhasil ditambahkan.');
    }

    public function destroy(Feedback $feedback)
    {
        $user = Auth::user();

        if (!$user || (!$user->is_admin && $feedback->user_id !== $user->id)) {
            abort(403, 'Tidak memiliki izin untuk menghapus feedback ini.');
        }

        $feedback->delete();

        return redirect()->back()
            ->with('success', 'Feedback berhasil dihapus.');
    }
}
