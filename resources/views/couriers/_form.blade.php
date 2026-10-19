
@php
    $isEdit = isset($courier);
@endphp

<div class="row g-4">
    <div class="col-12 col-lg-6">
        <label for="name" class="form-label fw-semibold">
            Nama lengkap <span class="text-danger">*</span>
        </label>

        <input type="text"
               name="name"
               id="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $courier->name ?? '') }}"
               maxlength="150"
               required>

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-lg-6">
        <label for="email" class="form-label fw-semibold">
            Email <span class="text-danger">*</span>
        </label>

        <input type="email"
               name="email"
               id="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $courier->email ?? '') }}"
               maxlength="150"
               required>

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-lg-6">
        <label for="phone" class="form-label fw-semibold">
            Nomor telepon <span class="text-danger">*</span>
        </label>

        <input type="tel"
               name="phone"
               id="phone"
               class="form-control @error('phone') is-invalid @enderror"
               value="{{ old('phone', $courier->phone ?? '') }}"
               maxlength="20"
               required>

        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-lg-6">
        <label for="level" class="form-label fw-semibold">
            Level kurir <span class="text-danger">*</span>
        </label>

        <select name="level"
                id="level"
                class="form-select @error('level') is-invalid @enderror"
                required>
            <option value="">Pilih level</option>

            @foreach (range(1, 5) as $level)
                <option value="{{ $level }}"
                    @selected((string) old('level', $courier->level ?? '') === (string) $level)>
                    Level {{ $level }}
                </option>
            @endforeach
        </select>

        @error('level')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="address" class="form-label fw-semibold">Alamat</label>

        <textarea name="address"
                  id="address"
                  rows="3"
                  class="form-control @error('address') is-invalid @enderror"
                  placeholder="Masukkan alamat lengkap">{{ old('address', $courier->address ?? '') }}</textarea>

        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="is_active" class="form-label fw-semibold">
            Status kurir <span class="text-danger">*</span>
        </label>

        <select name="is_active"
                id="is_active"
                class="form-select @error('is_active') is-invalid @enderror"
                required>
            <option value="1"
                @selected((string) old('is_active', isset($courier) ? (int) $courier->is_active : '1') === '1')>
                Aktif
            </option>

            <option value="0"
                @selected((string) old('is_active', isset($courier) ? (int) $courier->is_active : '1') === '0')>
                Tidak aktif
            </option>
        </select>

        @error('is_active')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex flex-wrap justify-content-end gap-2 mt-4 pt-4 border-top">
    <a href="{{ route('couriers.index') }}" class="btn btn-light border px-4">
        Batal
    </a>

    <button type="submit" class="btn btn-primary px-4">
        <i class="bi bi-check-lg me-2"></i>
        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Kurir' }}
    </button>
</div>
