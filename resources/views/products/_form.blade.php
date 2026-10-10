@php
    $product = $product ?? null;

    $selectedSupplierIds = old(
        'supplier_ids',
        $product
        ? $product->suppliers->pluck('supplier_id')->all()
        : []
    );

    $selectedSupplierIds = array_map(
        'strval',
        (array) $selectedSupplierIds
    );
@endphp

@if ($errors->any())
    <div class="alert alert-error" role="alert">
        <strong>Periksa kembali data yang dimasukkan.</strong>

        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ $product ? route('products.update', $product) : route('products.store') }}">

    @csrf

    @if ($product)
        @method('PUT')
    @endif

    <div class="form-grid">
        <div class="field">
            <label for="sku">SKU / Kode Produk <span class="required">*</span></label>

            <input type="text" id="sku" name="sku" value="{{ old('sku', $product?->sku ?? '') }}" maxlength="50"
                placeholder="Contoh: BRG-001" required>

            @error('sku')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="product_name">Nama Produk <span class="required">*</span></label>

            <input type="text" id="product_name" name="product_name"
                value="{{ old('product_name', $product?->product_name ?? '') }}" maxlength="150"
                placeholder="Masukkan nama produk" required>

            @error('product_name')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="category_id">Kategori <span class="required">*</span></label>

            <select id="category_id" name="category_id" required>
                <option value="">Pilih kategori</option>

                @foreach ($categories as $category)
                    <option value="{{ $category->category_id }}" @selected(
                        (string) old('category_id', $product?->category_id ?? '')
                        === (string) $category->category_id
                    )>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>

            @error('category_id')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="price">Harga Produk (Rp) <span class="required">*</span></label>

            <input type="number" id="price" name="price" value="{{ old('price', $product?->price ?? '') }}" min="0"
                step="0.01" placeholder="Contoh: 150000" required>

            @error('price')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="minimum_stock">Minimum Stok <span class="required">*</span></label>

            <input type="number" id="minimum_stock" name="minimum_stock"
                value="{{ old('minimum_stock', $product?->minimum_stock ?? 5) }}" min="0" step="1" required>

            @error('minimum_stock')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="expiry_date">Tanggal Kedaluwarsa</label>

            <input type="date" id="expiry_date" name="expiry_date"
                value="{{ old('expiry_date', $product?->expiry_date?->format('Y-m-d') ?? '') }}">

            @error('expiry_date')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="field field-full">
            <label for="description">Deskripsi Produk</label>

            <textarea id="description" name="description" rows="4"
                placeholder="Tambahkan deskripsi produk jika diperlukan...">{{ old('description', $product?->description ?? '') }}</textarea>

            @error('description')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="field field-full">
            <label>Pemasok Produk</label>

            {{-- Menandakan bahwa bagian pemasok dikirim oleh form. --}}
            <input type="hidden" name="supplier_selection_submitted" value="1">

            <div
                style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px; margin-top:10px;">
                @forelse ($suppliers as $supplier)
                    <label for="supplier_{{ $supplier->supplier_id }}"
                        style="display:flex; align-items:flex-start; gap:10px; margin:0; padding:13px; border:1px solid #dce3ec; border-radius:9px; cursor:pointer; font-weight:400;">
                        <input type="checkbox" id="supplier_{{ $supplier->supplier_id }}" name="supplier_ids[]"
                            value="{{ $supplier->supplier_id }}" @checked(
                                in_array(
                                    (string) $supplier->supplier_id,
                                    $selectedSupplierIds,
                                    true
                                )
                            ) style="width:auto; margin-top:3px; flex-shrink:0;">

                        <span>
                            <strong style="display:block; margin-bottom:4px;">
                                {{ $supplier->supplier_name }}
                            </strong>

                            @if ($supplier->email)
                                <small style="display:block; color:#718096; font-weight:400;">
                                    {{ $supplier->email }}
                                </small>
                            @elseif ($supplier->phone)
                                <small style="display:block; color:#718096; font-weight:400;">
                                    {{ $supplier->phone }}
                                </small>
                            @endif
                        </span>
                    </label>
                @empty
                    <p style="color:#718096; font-size:14px;">
                        Belum ada pemasok. Tambahkan data pemasok terlebih dahulu.
                    </p>
                @endforelse
            </div>

            <small style="display:block; margin-top:9px; color:#718096;">
                Pilih satu atau beberapa pemasok yang menyediakan produk ini.
                Bagian ini boleh dikosongkan.
            </small>

            @error('supplier_ids')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="stock-note">
        @if ($product)
            Stok saat ini:
            <strong>{{ number_format($product->stock) }}</strong> unit.
            Perubahan stok harus dilakukan melalui transaksi barang masuk atau keluar.
        @else
            Stok awal produk akan diatur menjadi 0. Gunakan transaksi barang masuk
            untuk menambahkan persediaan.
        @endif
    </div>

    <div class="form-actions">
        <a href="{{ route('products.index') }}" class="button button-secondary">
            Batal
        </a>

        <button type="submit" class="button button-primary">
            {{ $product ? 'Simpan Perubahan' : 'Simpan Produk' }}
        </button>
    </div>
</form>