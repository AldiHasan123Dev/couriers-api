
@extends('layouts.app')

@section('title', 'Tambah Kurir')
@section('page-heading', 'Tambah Kurir')

@section('content')
    <div class="mb-4">
        <a href="{{ route('couriers.index') }}"
           class="text-decoration-none text-muted-custom">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke daftar
        </a>

        <h1 class="h3 fw-bold mt-3 mb-1">Tambah Kurir Baru</h1>
        <p class="text-muted-custom mb-0">
            Lengkapi informasi kurir di bawah ini.
        </p>
    </div>

    <div class="content-card p-3 p-lg-4">
        <div class="d-flex align-items-center gap-3 mb-4 pb-4 border-bottom">
            <div class="stat-icon">
                <i class="bi bi-person-plus"></i>
            </div>
            <div>
                <h2 class="h5 fw-bold mb-1">Informasi Kurir</h2>
                <p class="text-muted-custom mb-0">
                    Kolom bertanda * wajib diisi.
                </p>
            </div>
        </div>

        <form action="{{ route('couriers.store') }}" method="POST">
            @csrf
            @include('couriers._form')
        </form>
    </div>
@endsection
