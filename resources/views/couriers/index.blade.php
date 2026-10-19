
@extends('layouts.app')

@section('title', 'Data Kurir')
@section('page-heading', 'Data Kurir')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Master Data Kurir</h1>
            <p class="text-muted-custom mb-0">
                Kelola informasi dan tingkat kurir perusahaan.
            </p>
        </div>

        <a href="{{ route('couriers.create') }}" class="btn btn-primary px-3 py-2">
            <i class="bi bi-plus-lg me-2"></i>Tambah Kurir
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted-custom mb-2">Total Kurir</div>
                    <div class="fs-2 fw-bold">{{ number_format($statistics['total']) }}</div>
                    <small class="text-muted-custom">Seluruh data kurir</small>
                </div>
                <div class="stat-icon"><i class="bi bi-people"></i></div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted-custom mb-2">Kurir Aktif</div>
                    <div class="fs-2 fw-bold">{{ number_format($statistics['active']) }}</div>
                    <small class="text-success">Siap beroperasi</small>
                </div>
                <div class="stat-icon" style="background:#e8f8ef;color:#16834a">
                    <i class="bi bi-person-check"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted-custom mb-2">Kurir Tidak Aktif</div>
                    <div class="fs-2 fw-bold">{{ number_format($statistics['inactive']) }}</div>
                    <small class="text-muted-custom">Tidak beroperasi</small>
                </div>
                <div class="stat-icon" style="background:#fff0e8;color:#c65b21">
                    <i class="bi bi-person-dash"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="content-card p-3 p-lg-4 mb-4">
        <form action="{{ route('couriers.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-lg-4">
                    <label for="search" class="form-label fw-semibold">
                        Cari kurir
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text"
                               id="search"
                               name="search"
                               class="form-control"
                               placeholder="Nama kurir..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <label for="level" class="form-label fw-semibold">Level</label>
                    <select name="level" id="level" class="form-select">
                        <option value="">Semua level</option>
                        @foreach (range(1, 5) as $level)
                            <option value="{{ $level }}"
                                @selected(request('level') == (string) $level)>
                                Level {{ $level }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-lg-3">
                    <label for="sort" class="form-label fw-semibold">Urutkan</label>
                    <select name="sort" id="sort" class="form-select">
                        <option value="name"
                            @selected(request('sort', 'name') === 'name')>
                            Nama kurir
                        </option>
                        <option value="registered_at"
                            @selected(request('sort') === 'registered_at')>
                            Tanggal pendaftaran
                        </option>
                    </select>
                </div>

                <div class="col-6 col-lg-1">
                    <label for="direction" class="form-label fw-semibold">Urutan</label>
                    <select name="direction" id="direction" class="form-select">
                        <option value="asc"
                            @selected(request('direction', 'asc') === 'asc')>
                            A-Z
                        </option>
                        <option value="desc"
                            @selected(request('direction') === 'desc')>
                            Z-A
                        </option>
                    </select>
                </div>

                <div class="col-6 col-lg-2">
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-funnel me-1"></i> Terapkan
                    </button>

                    <a href="{{ route('couriers.index') }}"
                       class="btn btn-light border w-100">
                        Reset filter
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="content-card overflow-hidden">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 p-3 p-lg-4 border-bottom">
            <div>
                <h2 class="h5 fw-bold mb-1">Daftar Kurir</h2>
                <small class="text-muted-custom">
                    Menampilkan {{ $couriers->firstItem() ?? 0 }}–{{ $couriers->lastItem() ?? 0 }}
                    dari {{ number_format($couriers->total()) }} data
                </small>
            </div>

            <form action="{{ route('couriers.index') }}" method="GET"
                  class="d-flex align-items-center gap-2">
                @foreach (request()->except('per_page', 'page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach

                <label for="per_page" class="small text-muted-custom">Baris:</label>
                <select name="per_page" id="per_page"
                        class="form-select form-select-sm"
                        onchange="this.form.submit()"
                        style="width:80px">
                    @foreach ([10, 20, 50, 100] as $size)
                        <option value="{{ $size }}"
                            @selected((int) request('per_page', 10) === $size)>
                            {{ $size }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Kurir</th>
                        <th>Kontak</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Tanggal Daftar</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($couriers as $courier)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar">
                                        {{ mb_strtoupper(mb_substr($courier->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('couriers.show', $courier) }}"
                                           class="fw-semibold text-dark text-decoration-none">
                                            {{ $courier->name }}
                                        </a>
                                        <div class="small text-muted-custom">
                                            ID #{{ $courier->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div>{{ $courier->email }}</div>
                                <small class="text-muted-custom">
                                    {{ $courier->phone }}
                                </small>
                            </td>

                            <td>
                                <span class="badge rounded-pill text-primary px-3 py-2"
                                      style="background:#eef2ff">
                                    Level {{ $courier->level }}
                                </span>
                            </td>

                            <td>
                                @if ($courier->is_active)
                                    <span class="badge rounded-pill text-success px-3 py-2"
                                          style="background:#e8f8ef">
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge rounded-pill text-secondary px-3 py-2"
                                          style="background:#edf0f4">
                                        Tidak aktif
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div>{{ $courier->created_at->format('d M Y') }}</div>
                                <small class="text-muted-custom">
                                    {{ $courier->created_at->format('H:i') }}
                                </small>
                            </td>

                            <td>
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('couriers.show', $courier) }}"
                                       class="btn btn-sm btn-light border"
                                       title="Detail" aria-label="Detail kurir">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('couriers.edit', $courier) }}"
                                       class="btn btn-sm btn-light border"
                                       title="Edit" aria-label="Edit kurir">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('couriers.destroy', $courier) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus kurir ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-light border text-danger"
                                                title="Hapus"
                                                aria-label="Hapus kurir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-secondary"></i>
                                <h3 class="h6 fw-bold mt-3">Data tidak ditemukan</h3>
                                <p class="text-muted-custom mb-3">
                                    Coba ubah kata kunci atau filter pencarian.
                                </p>
                                <a href="{{ route('couriers.index') }}"
                                   class="btn btn-outline-primary btn-sm">
                                    Tampilkan semua kurir
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($couriers->hasPages())
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 p-3 p-lg-4">
                <small class="text-muted-custom">
                    Halaman {{ $couriers->currentPage() }}
                    dari {{ $couriers->lastPage() }}
                </small>

                {{ $couriers->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
