@php
    $supplier = $supplier ?? null;
@endphp

@if ($errors->any())
    <div class="alert alert-error" role="alert">
        <strong>Periksa kembali data yang dimasukkan.</strong>

        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ $supplier ? route('suppliers.update', $supplier) : route('suppliers.store') }}">
    @csrf

    @if ($supplier)
        @method('PUT')
    @endif

    <div class="form-grid">
        <div class="field">
            <label for="supplier_name">
                Nama Supplier <span class="required">*</span>
            </label>

            <input type="text" id="supplier_name" name="supplier_name"
                value="{{ old('supplier_name', $supplier?->supplier_name ?? '') }}" maxlength="150"
                placeholder="Contoh: PT Sinar Digital" required>

            @error('supplier_name')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="contact_info">Nama Kontak</label>

            <input type="text" id="contact_info" name="contact_info"
                value="{{ old('contact_info', $supplier?->contact_info ?? '') }}" maxlength="255"
                placeholder="Nama orang yang dapat dihubungi">

            @error('contact_info')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="email">Email</label>

            <input type="email" id="email" name="email" value="{{ old('email', $supplier?->email ?? '') }}"
                maxlength="100" placeholder="supplier@example.com">

            @error('email')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="phone">Nomor Telepon</label>

            <input type="text" id="phone" name="phone" value="{{ old('phone', $supplier?->phone ?? '') }}"
                maxlength="30" placeholder="Nomor telepon supplier">

            @error('phone')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="field field-full">
            <label for="location">Alamat Supplier</label>

            <textarea id="location" name="location" rows="4"
                placeholder="Masukkan alamat supplier...">{{ old('location', $supplier?->location ?? '') }}</textarea>

            @error('location')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('suppliers.index') }}" class="button button-secondary">
            Batal
        </a>

        <button type="submit" class="button button-primary">
            {{ $supplier ? 'Simpan Perubahan' : 'Simpan Supplier' }}
        </button>
    </div>
</form>