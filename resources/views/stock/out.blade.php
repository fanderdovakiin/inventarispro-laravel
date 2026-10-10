@extends('layouts.app')

@section('title', 'Barang Keluar — InventarisPro')

@push('styles')
    <style>
        .page-main {
            max-width: 850px;
            margin: 0 auto;
            padding: 32px 20px;
        }

        .stock-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 18px;
            margin-bottom: 28px;
            padding: 14px 16px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        .stock-nav a {
            color: #475569;
            text-decoration: none;
            font-size: 13px;
        }

        .stock-nav a:hover,
        .stock-nav a.active {
            color: #01498b;
            font-weight: 600;
        }

        .page-heading {
            margin-bottom: 24px;
        }

        .page-heading h1 {
            margin: 0 0 8px;
            font-size: 28px;
        }

        .page-heading p {
            margin: 0;
            color: #718096;
            line-height: 1.6;
            font-size: 14px;
        }

        .card {
            background: white;
            border: 1px solid #e3e8ef;
            border-radius: 12px;
            padding: 28px;
            box-shadow: 0 4px 15px rgba(20, 40, 70, .04);
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 9px;
        }

        .required {
            color: #c53030;
        }

        .card input,
        .card select,
        .card textarea {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #d5dce5;
            border-radius: 8px;
            background: white;
            font: inherit;
            font-size: 14px;
            color: #243247;
        }

        .card input,
        .card select {
            min-height: 44px;
        }

        .card input:focus,
        .card select:focus,
        .card textarea:focus {
            outline: none;
            border-color: #01498b;
            box-shadow: 0 0 0 3px rgba(1, 73, 139, .1);
        }

        .card textarea {
            min-height: 100px;
            resize: vertical;
        }

        .help-text {
            display: block;
            margin-top: 7px;
            font-size: 12px;
            color: #718096;
        }

        .field-error {
            display: block;
            color: #c53030;
            font-size: 13px;
            margin-top: 7px;
        }

        .alert {
            padding: 13px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.6;
        }

        .alert-success {
            background: #e6f7ed;
            color: #17663a;
            border: 1px solid #b7ebc9;
        }

        .alert-error {
            background: #fff0f0;
            color: #a52828;
            border: 1px solid #f3c1c1;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding-top: 8px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 17px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: #01498b;
            color: white;
        }

        .btn-primary:hover {
            background: #00386d;
        }

        .btn-secondary {
            background: white;
            border-color: #d5dce5;
            color: #344256;
        }

        .btn-secondary:hover {
            background: #f4f6fa;
        }

        @media (max-width: 600px) {
            .page-main {
                padding: 24px 14px;
            }

            .card {
                padding: 20px;
            }

            .page-heading h1 {
                font-size: 24px;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .form-actions .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <nav class="stock-nav" aria-label="Navigasi stok">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('products.index') }}">Produk</a>
        <a href="{{ route('stock.in.create') }}">Barang Masuk</a>
        <a href="{{ route('stock.out.create') }}" class="active">Barang Keluar</a>
        <a href="{{ route('stock.history') }}">Riwayat Stok</a>
    </nav>

    <div class="page-heading">
        <h1>Barang Keluar</h1>
        <p>
            Catat pengeluaran barang untuk memperbarui stok
            dan menyimpan riwayat transaksi.
        </p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <strong>Transaksi belum dapat disimpan.</strong>
            <ul style="margin-bottom: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="card">
        <form action="{{ route('stock.out.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="product_id">
                    Produk <span class="required">*</span>
                </label>

                <select id="product_id" name="product_id" required>
                    <option value="">Pilih produk</option>

                    @foreach ($products as $product)
                        <option value="{{ $product->product_id }}" @selected((string) old('product_id') === (string) $product->product_id)>
                            {{ $product->sku }} — {{ $product->product_name }}
                            (Stok tersedia: {{ $product->stock }})
                        </option>
                    @endforeach
                </select>

                @error('product_id')
                    <span class="field-error">{{ $message }}</span>
                @enderror

                <span class="help-text">
                    Periksa stok tersedia sebelum melakukan transaksi.
                </span>
            </div>

            <div class="form-group">
                <label for="quantity">
                    Jumlah Barang Keluar <span class="required">*</span>
                </label>

                <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" min="1" step="1"
                    placeholder="Masukkan jumlah barang" required>

                @error('quantity')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="notes">Catatan</label>

                <textarea id="notes" name="notes" maxlength="1000"
                    placeholder="Contoh: Barang keluar untuk kebutuhan operasional.">{{ old('notes') }}</textarea>

                @error('notes')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    Simpan Barang Keluar
                </button>
            </div>
        </form>
    </section>
@endsection