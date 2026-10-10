
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Masuk | InventarisPro</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6fa;
            color: #243247;
        }

        .navbar {
            background: #01498b;
            color: white;
            padding: 18px 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .brand {
            font-size: 21px;
            font-weight: 700;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        .logout-form {
            display: inline;
        }

        .logout-button {
            border: 1px solid rgba(255,255,255,.6);
            background: transparent;
            color: white;
            padding: 8px 12px;
            border-radius: 7px;
            cursor: pointer;
        }

        .container {
            max-width: 850px;
            margin: 35px auto;
            padding: 0 20px;
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

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 9px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #d5dce5;
            border-radius: 8px;
            background: white;
            font-size: 14px;
            color: #243247;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #01498b;
            box-shadow: 0 0 0 3px rgba(1, 73, 139, .1);
        }

        textarea {
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
            display: inline-block;
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
            .container {
                margin-top: 24px;
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
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <header class="navbar">
        <div class="brand">InventarisPro</div>

        <nav class="nav-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('products.index') }}">Produk</a>
            <a href="{{ route('stock.in.create') }}">Barang Masuk</a>
            <a href="{{ route('stock.out.create') }}">Barang Keluar</a>
            <a href="{{ route('stock.history') }}">Riwayat Stok</a>

            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-button">Keluar</button>
            </form>
        </nav>
    </header>

    <main class="container">
        <div class="page-heading">
            <h1>Barang Masuk</h1>
            <p>
                Catat penerimaan barang untuk menambahkan stok produk
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
                <strong>Data belum dapat disimpan.</strong>
                <ul style="margin-bottom: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="card">
            <form action="{{ route('stock.in.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="product_id">Produk <span style="color: #c53030;">*</span></label>

                    <select id="product_id" name="product_id" required>
                        <option value="">Pilih produk</option>

                        @foreach ($products as $product)
                            <option
                                value="{{ $product->product_id }}"
                                @selected((string) old('product_id') === (string) $product->product_id)
                            >
                                {{ $product->sku }} — {{ $product->product_name }}
                                (Stok saat ini: {{ $product->stock }})
                            </option>
                        @endforeach
                    </select>

                    @error('product_id')
                        <span class="field-error">{{ $message }}</span>
                    @enderror

                    <span class="help-text">
                        Pilih produk yang akan ditambahkan stoknya.
                    </span>
                </div>

                <div class="form-group">
                    <label for="quantity">Jumlah Barang Masuk <span style="color: #c53030;">*</span></label>

                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        value="{{ old('quantity') }}"
                        min="1"
                        step="1"
                        placeholder="Masukkan jumlah barang"
                        required
                    >

                    @error('quantity')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="supplier_id">Pemasok</label>

                    <select id="supplier_id" name="supplier_id">
                        <option value="">Tidak ditentukan</option>

                        @foreach ($suppliers as $supplier)
                            <option
                                value="{{ $supplier->supplier_id }}"
                                @selected((string) old('supplier_id') === (string) $supplier->supplier_id)
                            >
                                {{ $supplier->supplier_name }}
                            </option>
                        @endforeach
                    </select>

                    @error('supplier_id')
                        <span class="field-error">{{ $message }}</span>
                    @enderror

                    <span class="help-text">
                        Pemasok bersifat opsional.
                    </span>
                </div>

                <div class="form-group">
                    <label for="notes">Catatan</label>

                    <textarea
                        id="notes"
                        name="notes"
                        maxlength="1000"
                        placeholder="Contoh: Pembelian barang untuk penambahan stok."
                    >{{ old('notes') }}</textarea>

                    @error('notes')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Simpan Barang Masuk
                    </button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
```