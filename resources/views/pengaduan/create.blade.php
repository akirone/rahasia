@extends('layouts.app')

@section('title', 'Buat Pengaduan')

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

        <div class="row">
            <div class="col-lg-8">
                <!-- Form Pengaduan -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-file-earmark-plus-fill"></i> Buat Pengaduan Baru
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="kategori_id" class="form-label">
                                    Kategori Pengaduan <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id"
                                    name="kategori_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}"
                                            {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
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
                                    id="lokasi" name="lokasi" value="{{ old('lokasi') }}"
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
                                    rows="6" placeholder="Jelaskan detail pengaduan Anda..." required>{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Berikan penjelasan sedetail mungkin</small>
                            </div>

                            <div class="mb-3">
                                <label for="foto" class="form-label">
                                    Foto Pendukung (Opsional)
                                </label>
                                <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                    id="foto" name="foto" accept="image/*">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 4MB</small>
                            </div>

                            <hr>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send-fill"></i> Kirim Pengaduan
                                </button>
                                <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">
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
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <strong>Catatan:</strong><br>
                            <small>Pengaduan Anda akan direview oleh admin. Status awal adalah "Menunggu".</small>
                        </div>
                    </div>
                </div>

                <!-- Tips Panel -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0"><i class="bi bi-lightbulb"></i> Tips Pengaduan yang Baik</h6>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0" style="font-size: 0.875rem;">
                            <li class="mb-2">Jelaskan lokasi kejadian secara spesifik</li>
                            <li class="mb-2">Berikan keterangan yang detail dan jelas</li>
                            <li class="mb-2">Sertakan foto jika memungkinkan</li>
                            <li class="mb-2">Gunakan bahasa yang sopan dan formal</li>
                            <li class="mb-0">Pastikan semua data yang diisi benar</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
