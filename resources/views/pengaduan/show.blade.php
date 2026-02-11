@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@push('styles')
    <style>
        /* Timeline Styles */
        .timeline {
            position: relative;
            padding: 0;
            list-style: none;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 20px;
            width: 2px;
            background: #e2e8f0;
        }

        .timeline-item {
            position: relative;
            padding-left: 50px;
            padding-bottom: 25px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-marker {
            position: absolute;
            left: 0;
            top: 0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            z-index: 1;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .timeline-content {
            background: #f8f9fa;
            padding: 12px 15px;
            border-radius: 8px;
            border-left: 3px solid #dee2e6;
        }

        .timeline-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 4px;
            font-size: 14px;
        }

        .timeline-time {
            color: #718096;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .timeline-desc {
            color: #4a5568;
            font-size: 13px;
            margin: 0;
        }

        .timeline-item .bg-success+.timeline-content {
            border-left-color: #48bb78;
            background: #f0fdf4;
        }

        .timeline-item .bg-warning+.timeline-content {
            border-left-color: #f59e0b;
            background: #fffbeb;
        }

        .timeline-item .bg-info+.timeline-content {
            border-left-color: #3b82f6;
            background: #eff6ff;
        }

        .timeline-item .bg-primary+.timeline-content {
            border-left-color: #667eea;
            background: #eef2ff;
        }

        .timeline-item .bg-secondary+.timeline-content {
            border-left-color: #718096;
            background: #f7fafc;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4">
        {{-- Success & Error Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                <!-- Pengaduan Detail -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-file-text"></i> Detail Pengaduan
                            </h5>
                            <span class="badge bg-{{ $pengaduan->status_badge }} fs-6">
                                {{ $pengaduan->status }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="text-muted small">Kategori</label>
                            <p class="mb-0">
                                <span class="badge bg-secondary fs-6">{{ $pengaduan->kategori->nama }}</span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">Tanggal Pengaduan</label>
                            <p class="mb-0">
                                <i class="bi bi-calendar-event"></i>
                                {{ $pengaduan->tanggal->format('d F Y, H:i') }} WIB
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">Lokasi Kejadian</label>
                            <p class="mb-0">
                                <i class="bi bi-geo-alt-fill"></i>
                                <strong>{{ $pengaduan->lokasi }}</strong>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">Keterangan</label>
                            <p class="mb-0" style="white-space: pre-line;">{{ $pengaduan->keterangan }}</p>
                        </div>

                        @if ($pengaduan->foto)
                            <div class="mb-3">
                                <label class="text-muted small">Foto Pendukung</label>
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $pengaduan->foto) }}"
                                        class="img-fluid rounded shadow-sm" alt="Foto Pengaduan"
                                        style="max-height: 400px; cursor: pointer;" data-bs-toggle="modal"
                                        data-bs-target="#imageModal">
                                </div>
                            </div>
                        @endif

                        <hr>

                        <div class="d-flex gap-2">
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                            @endif

                            {{-- Only owner can edit/delete their own pengaduan if status is Menunggu --}}
                            @if (!auth()->user()->isAdmin() && $pengaduan->user_id == auth()->id() && $pengaduan->status == 'Menunggu')
                                <a href="{{ route('pengaduan.edit', $pengaduan) }}" class="btn btn-warning text-white">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('pengaduan.destroy', $pengaduan) }}" method="POST"
                                    style="display: inline-block;"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- User Info -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0"><i class="bi bi-person"></i> Pelapor</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><strong>{{ $pengaduan->user->name }}</strong></p>
                        <p class="text-muted mb-1"><small>NIS: {{ $pengaduan->user->nis }}</small></p>
                        <p class="text-muted mb-0"><small>Kelas: {{ $pengaduan->user->kelas }}</small></p>
                    </div>
                </div>

                <!-- Status Update (Admin Only) -->
                @if (auth()->user()->isAdmin())
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="mb-0"><i class="bi bi-gear"></i> Update Status</h6>
                        </div>
                        <div class="card-body">
                            @if ($errors->has('status'))
                                <div class="alert alert-danger alert-sm">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                    {{ $errors->first('status') }}
                                </div>
                            @endif

                            <form action="{{ route('pengaduan.updateStatus', $pengaduan) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="Menunggu" {{ $pengaduan->status == 'Menunggu' ? 'selected' : '' }}>
                                            Menunggu</option>
                                        <option value="Proses" {{ $pengaduan->status == 'Proses' ? 'selected' : '' }}>
                                            Proses</option>
                                        <option value="Selesai" {{ $pengaduan->status == 'Selesai' ? 'selected' : '' }}>
                                            Selesai</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-check-circle"></i> Update Status
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Feedback Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0">
                            <i class="bi bi-chat-left-text"></i> Feedback & Umpan Balik
                            <span class="badge bg-info">{{ $pengaduan->feedback->count() }}</span>
                        </h6>
                    </div>
                    <div class="card-body">
                        @if ($pengaduan->feedback->count() > 0)
                            @foreach ($pengaduan->feedback->sortByDesc('created_at') as $feedback)
                                <div class="alert alert-info mb-2">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block mb-1">
                                                <i class="bi bi-person-badge"></i> {{ $feedback->user->name }} •
                                                {{ $feedback->created_at->format('d/m/Y H:i') }}
                                            </small>
                                            <p class="mb-0">{{ $feedback->isi }}</p>
                                        </div>
                                        @if (auth()->user()->isAdmin())
                                            <form action="{{ route('feedback.destroy', $feedback) }}" method="POST"
                                                style="display: inline-block;"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus feedback ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted mb-0 text-center py-3">
                                <i class="bi bi-chat-dots" style="font-size: 2rem; opacity: 0.3;"></i><br>
                                Belum ada feedback
                            </p>
                        @endif

                        @if (auth()->user()->isAdmin())
                            <hr>

                            @if ($errors->has('isi'))
                                <div class="alert alert-danger alert-sm mb-2">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                    {{ $errors->first('isi') }}
                                </div>
                            @endif

                            <form action="{{ route('feedback.store', $pengaduan) }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <textarea name="isi" class="form-control @error('isi') is-invalid @enderror" rows="3" placeholder="Tulis feedback atau tanggapan..." required>{{ old('isi') }}</textarea>
                                    @error('isi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    <i class="bi bi-send"></i> Kirim Feedback
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Timeline & Histori -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0">
                            <i class="bi bi-clock-history"></i> Timeline & Histori
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <!-- Current Status -->
                            <div class="timeline-item">
                                <div
                                    class="timeline-marker bg-{{ $pengaduan->status == 'Selesai' ? 'success' : ($pengaduan->status == 'Proses' ? 'warning' : 'secondary') }}">
                                    <i
                                        class="bi bi-{{ $pengaduan->status == 'Selesai' ? 'check-circle-fill' : ($pengaduan->status == 'Proses' ? 'hourglass-split' : 'clock-fill') }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Status: {{ $pengaduan->status }}</div>
                                    <div class="timeline-time">{{ $pengaduan->updated_at->format('d F Y, H:i') }} WIB
                                    </div>
                                    <div class="timeline-desc">Terakhir diperbarui</div>
                                </div>
                            </div>

                            <!-- Feedback History -->
                            @foreach ($pengaduan->feedback->sortByDesc('created_at') as $feedback)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-info">
                                        <i class="bi bi-chat-left-text-fill"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">Feedback dari {{ $feedback->user->name }}</div>
                                        <div class="timeline-time">{{ $feedback->created_at->format('d F Y, H:i') }} WIB
                                        </div>
                                        <div class="timeline-desc">{{ Str::limit($feedback->isi, 50) }}</div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Created -->
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary">
                                    <i class="bi bi-file-earmark-plus-fill"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Pengaduan Dibuat</div>
                                    <div class="timeline-time">{{ $pengaduan->tanggal->format('d F Y, H:i') }} WIB</div>
                                    <div class="timeline-desc">Oleh {{ $pengaduan->user->name }}
                                        ({{ $pengaduan->user->kelas }})</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    @if ($pengaduan->foto)
        <div class="modal fade" id="imageModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Foto Pengaduan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('storage/' . $pengaduan->foto) }}" class="img-fluid" alt="Foto Pengaduan">
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
