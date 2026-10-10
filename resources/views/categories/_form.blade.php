@php
    $category = $category ?? null;
@endphp

@if ($errors->any())
    <div class="alert alert-error" role="alert">
        <strong>Periksa kembali data yang dimasukkan.</strong>

        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ $category ? route('categories.update', $category) : route('categories.store') }}">
    @csrf

    @if ($category)
        @method('PUT')
    @endif

    <div class="field">
        <label for="category_name">Nama Kategori <span class="required">*</span></label>

        <input type="text" id="category_name" name="category_name"
            value="{{ old('category_name', $category?->category_name ?? '') }}" maxlength="100"
            placeholder="Contoh: Elektronik" autocomplete="off" required>

        @error('category_name')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </div>

    <div class="field">
        <label for="description">Deskripsi</label>

        <textarea id="description" name="description" rows="4"
            placeholder="Jelaskan kategori ini secara singkat...">{{ old('description', $category?->description ?? '') }}</textarea>

        @error('description')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-actions">
        <a href="{{ route('categories.index') }}" class="button button-secondary">
            Batal
        </a>

        <button type="submit" class="button button-primary">
            {{ $category ? 'Simpan Perubahan' : 'Simpan Kategori' }}
        </button>
    </div>
</form>