
@extends('layouts.app')

@section('title', 'Edit Kurir')
@section('page-heading', 'Edit Kurir')

@section('content')
    <div class="mb-4">
        <a href="{{ route('couriers.index') }}"
           class="text-decoration-none text-muted-custom">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke daftar
        </a>

        <h1 class="h3 fw-bold mt-3 mb-1">Edit Data Kurir</h1>
        <p class="text-muted-custom mb-0">
            Perbarui informasi {{ $courier->name }}.
        </p>
    </div>

    <div class="content-card p-3 p-lg-4">
        <div class="d-flex align-items-center gap-3 mb-4 pb-4 border-bottom">
            <div class="avatar" style="width:52px;height:52px">
                {{ mb_strtoupper(mb_substr($courier->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="h5 fw-bold mb-1">{{ $courier->name }}</h2>
                <small class="text-muted-custom">
                    ID Kurir #{{ $courier->id }}
                </small>
            </div>
        </div>

        <form action="{{ route('couriers.update', $courier) }}" method="POST">
            @csrf
            @method('PUT')

            @include('couriers._form', ['courier' => $courier])
        </form>
    </div>
@endsection
