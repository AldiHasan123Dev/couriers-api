
@extends('layouts.app')

@section('title', 'Detail Kurir')
@section('page-heading', 'Detail Kurir')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <a href="{{ route('couriers.index') }}"
               class="text-decoration-none text-muted-custom">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke daftar
            </a>

            <h1 class="h3 fw-bold mt-3 mb-1">Detail Kurir</h1>
            <p class="text-muted-custom mb-0">
                Informasi lengkap master data kurir.
            </p>
        </div>

        <a href="{{ route('couriers.edit', $courier) }}"
           class="btn btn-primary px-4">
            <i class="bi bi-pencil me-2"></i>Edit Data
        </a>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-4">
            <div class="content-card p-4 text-center">
                <div class="avatar mx-auto mb-3"
                     style="width:88px;height:88px;font-size:2rem">
                    {{ mb_strtoupper(mb_substr($courier->name, 0, 1)) }}
                </div>

                <h2 class="h4 fw-bold mb-1">{{ $courier->name }}</h2>

                <p class="text-muted-custom mb-3">
                    ID Kurir #{{ $courier->id }}
                </p>

                <span class="badge rounded-pill text-primary px-3 py-2"
                      style="background:#eef2ff">
                    Level {{ $courier->level }}
                </span>

                <div class="mt-3">
                    @if ($courier->is_active)
                        <span class="badge rounded-pill text-success px-3 py-2"
                              style="background:#e8f8ef">
                            <i class="bi bi-check-circle me-1"></i>Aktif
                        </span>
                    @else
                        <span class="badge rounded-pill text-secondary px-3 py-2"
                              style="background:#edf0f4">
                            Tidak aktif
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="content-card p-4">
                <h2 class="h5 fw-bold mb-4">Informasi Kurir</h2>

                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <small class="text-muted-custom d-block mb-2">
                            Nama lengkap
                        </small>
                        <div class="fw-semibold">{{ $courier->name }}</div>
                    </div>

                    <div class="col-12 col-md-6">
                        <small class="text-muted-custom d-block mb-2">
                            Email
                        </small>
                        <div class="fw-semibold text-break">
                            {{ $courier->email }}
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <small class="text-muted-custom d-block mb-2">
                            Nomor telepon
                        </small>
                        <div class="fw-semibold">{{ $courier->phone }}</div>
                    </div>

                    <div class="col-12 col-md-6">
                        <small class="text-muted-custom d-block mb-2">
                            Level kurir
                        </small>
                        <div class="fw-semibold">Level {{ $courier->level }}</div>
                    </div>

                    <div class="col-12">
                        <small class="text-muted-custom d-block mb-2">
                            Alamat
                        </small>
                        <div class="fw-semibold" style="white-space:pre-line">{{ $courier->address ?: 'Alamat belum diisi.' }}</div>
                    </div>

                    <div class="col-12 col-md-6">
                        <small class="text-muted-custom d-block mb-2">
                            Tanggal didaftarkan
                        </small>
                        <div class="fw-semibold">
                            {{ $courier->created_at->format('d F Y, H:i') }}
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <small class="text-muted-custom d-block mb-2">
                            Terakhir diperbarui
                        </small>
                        <div class="fw-semibold">
                            {{ $courier->updated_at->format('d F Y, H:i') }}
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <form action="{{ route('couriers.destroy', $courier) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus {{ addslashes($courier->name) }}?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-trash me-2"></i>Hapus Kurir
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
