@extends('layouts.app')

@section('title', 'Edit Pengaduan')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-white py-3">
                        <h4 class="mb-0">
                            <i class="bi bi-pencil-square"></i> Edit Pengaduan
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Terjadi kesalahan:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                <i class="bi bi-x-circle-fill me-2"></i>
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="alert alert-warning">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <strong>Catatan:</strong> Pengaduan hanya dapat diedit jika masih berstatus "Menunggu".
                        </div>

                        <form action="{{ route('pengaduan.update', $pengaduan) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
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

                            <div class="mb-4">
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

                            <div class="mb-4">
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

                            <div class="mb-4">
                                <label for="foto" class="form-label">
                                    Foto Pendukung (Opsional)
                                </label>

                                @if ($pengaduan->foto)
                                    <div class="mb-2">
                                        <p class="text-muted small mb-1">Foto saat ini:</p>
                                        <img src="{{ asset('storage/' . $pengaduan->foto) }}" class="img-thumbnail"
                                            style="max-height: 150px;" alt="Foto saat ini">
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

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning text-white">
                                    <i class="bi bi-check-circle-fill"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('pengaduan.show', $pengaduan) }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
