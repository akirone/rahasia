@extends('layouts.app')

@section('title', 'Edit Pengaduan')

@push('styles')
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4">
        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6 class="alert-heading">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Terjadi Kesalahan!
                </h6>
                <hr>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <!-- Form Edit Pengaduan -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-pencil-square"></i> Edit Pengaduan
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('pengaduan.update', $pengaduan) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="kategori_id" class="form-label">
                                    Kategori Pengaduan <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id"
                                    name="kategori_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}"
                                            {{ old('kategori_id', $pengaduan->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="lokasi" class="form-label">
                                    Lokasi Kejadian <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                    id="lokasi" name="lokasi" value="{{ old('lokasi', $pengaduan->lokasi) }}"
                                    placeholder="Contoh: Ruang Kelas XII RPL" required>
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Sebutkan lokasi spesifik kejadian</small>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">
                                    Keterangan Lengkap <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan"
                                    rows="6" placeholder="Jelaskan detail pengaduan Anda..." required>{{ old('keterangan', $pengaduan->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Berikan penjelasan sedetail mungkin</small>
                            </div>

                            <div class="mb-3">
                                <label for="foto" class="form-label">
                                    Foto Pendukung (Opsional)
                                </label>

                                @if ($pengaduan->foto)
                                    <div class="mb-2">
                                        <p class="text-muted small mb-1">Foto saat ini:</p>
                                        <img src="{{ asset('storage/' . $pengaduan->foto) }}"
                                            class="img-fluid rounded shadow-sm" alt="Foto Pengaduan"
                                            style="max-height: 400px;">
                                        <p class="text-muted small mt-1">Upload foto baru untuk mengganti foto lama</p>
                                    </div>
                                @endif

                                <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                    id="foto" name="foto" accept="image/*">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 4MB</small>
                            </div>

                            <hr>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning text-white">
                                    <i class="bi bi-check-circle-fill"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Info Panel -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0"><i class="bi bi-info-circle"></i> Informasi</h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Perhatian:</strong><br>
                            <small>Pengaduan hanya dapat diedit jika masih berstatus "Menunggu".</small>
                        </div>
                    </div>
                </div>

                <!-- Current Data Panel -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0"><i class="bi bi-file-text"></i> Data Saat Ini</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Status</small>
                            <p class="mb-0">
                                <span class="badge bg-{{ $pengaduan->status_badge }}">{{ $pengaduan->status }}</span>
                            </p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Tanggal Dibuat</small>
                            <p class="mb-0" style="font-size: 0.875rem;">
                                {{ $pengaduan->tanggal->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div class="mb-0">
                            <small class="text-muted">Kategori Saat Ini</small>
                            <p class="mb-0">
                                <span class="badge bg-secondary">{{ $pengaduan->kategori->nama }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tips Panel -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0"><i class="bi bi-lightbulb"></i> Tips Edit Pengaduan</h6>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0" style="font-size: 0.875rem;">
                            <li class="mb-2">Pastikan data yang diubah sudah benar</li>
                            <li class="mb-2">Perubahan akan menggantikan data lama</li>
                            <li class="mb-2">Foto baru akan mengganti foto lama</li>
                            <li class="mb-0">Simpan perubahan sebelum menutup halaman</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
