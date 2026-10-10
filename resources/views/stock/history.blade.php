<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Stok | InventarisPro</title>

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
            max-width: 1450px;
            margin: 32px auto;
            padding: 0 24px;
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
            padding: 22px;
            margin-bottom: 22px;
            box-shadow: 0 4px 15px rgba(20, 40, 70, .04);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(130px, 1fr));
            gap: 16px;
            align-items: end;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        input,
        select {
            width: 100%;
            min-width: 0;
            padding: 11px 12px;
            border: 1px solid #d5dce5;
            border-radius: 8px;
            background: white;
            font-size: 14px;
            color: #243247;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #01498b;
            box-shadow: 0 0 0 3px rgba(1, 73, 139, .1);
        }

        .filter-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            white-space: nowrap;
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
            color: #344256;
            border-color: #d5dce5;
        }

        .btn-secondary:hover {
            background: #f4f6fa;
        }

        .table-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .table-heading h2 {
            margin: 0;
            font-size: 18px;
        }

        .muted {
            color: #718096;
            font-size: 13px;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            min-width: 1000px;
        }

        thead {
            background: #f6f8fb;
        }

        th {
            color: #536176;
            font-weight: 600;
            text-align: left;
            white-space: nowrap;
        }

        th,
        td {
            padding: 14px 12px;
            border-bottom: 1px solid #e9edf3;
            vertical-align: top;
        }

        tbody tr:hover {
            background: #fafbfd;
        }

        .product-name {
            font-weight: 600;
            color: #243247;
            margin-bottom: 5px;
        }

        .sku {
            color: #718096;
            font-size: 12px;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-in {
            background: #e6f7ed;
            color: #17663a;
        }

        .badge-out {
            background: #fff0f0;
            color: #b42323;
        }

        .quantity-in {
            color: #168044;
            font-weight: 700;
        }

        .quantity-out {
            color: #c53030;
            font-weight: 700;
        }

        .empty-state {
            text-align: center;
            color: #718096;
            padding: 38px 15px;
        }

        .pagination-wrapper {
            margin-top: 20px;
            overflow-x: auto;
        }

        .pagination-wrapper nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .pagination-wrapper a,
        .pagination-wrapper span {
            font-size: 13px;
        }

        .pagination-wrapper svg {
            width: 18px;
            height: 18px;
        }

        @media (max-width: 1050px) {
            .filter-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            .container {
                padding: 0 14px;
                margin-top: 24px;
            }

            .card {
                padding: 16px;
            }

            .page-heading h1 {
                font-size: 24px;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .filter-actions .btn {
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
            <h1>Riwayat Stok</h1>
            <p>
                Pantau seluruh transaksi barang masuk dan keluar,
                termasuk perubahan stok dan pengguna yang mencatat transaksi.
            </p>
        </div>

        <section class="card">
            <form action="{{ route('stock.history') }}" method="GET">
                <div class="filter-grid">
                    <div class="form-group">
                        <label for="product_id">Produk</label>

                        <select id="product_id" name="product_id">
                            <option value="">Semua produk</option>

                            @foreach ($products as $product)
                                <option
                                    value="{{ $product->product_id }}"
                                    @selected((string) ($filters['product_id'] ?? '') === (string) $product->product_id)
                                >
                                    {{ $product->sku }} - {{ $product->product_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="type">Jenis Transaksi</label>

                        <select id="type" name="type">
                            <option value="">Semua jenis</option>
                            <option value="IN" @selected(($filters['type'] ?? '') === 'IN')>
                                Barang Masuk
                            </option>
                            <option value="OUT" @selected(($filters['type'] ?? '') === 'OUT')>
                                Barang Keluar
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="user_id">Pengguna</label>

                        <select id="user_id" name="user_id">
                            <option value="">Semua pengguna</option>

                            @foreach ($users as $user)
                                <option
                                    value="{{ $user->user_id }}"
                                    @selected((string) ($filters['user_id'] ?? '') === (string) $user->user_id)
                                >
                                    {{ $user->full_name ?: $user->username }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date_from">Dari Tanggal</label>

                        <input
                            type="date"
                            id="date_from"
                            name="date_from"
                            value="{{ $filters['date_from'] ?? '' }}"
                        >
                    </div>

                    <div class="form-group">
                        <label for="date_to">Sampai Tanggal</label>

                        <input
                            type="date"
                            id="date_to"
                            name="date_to"
                            value="{{ $filters['date_to'] ?? '' }}"
                        >
                    </div>
                </div>

                <div class="filter-actions" style="margin-top: 18px;">
                    <button type="submit" class="btn btn-primary">
                        Terapkan Filter
                    </button>

                    <a href="{{ route('stock.history') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </form>
        </section>

        <section class="card">
            <div class="table-heading">
                <h2>Daftar Transaksi</h2>
                <span class="muted">
                    {{ $movements->total() }} transaksi ditemukan
                </span>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Stok Sebelum</th>
                            <th>Stok Sesudah</th>
                            <th>Pengguna</th>
                            <th>Pemasok</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($movements as $movement)
                            <tr>
                                <td>
                                    {{ $movement->movement_date
                                        ? $movement->movement_date->format('d/m/Y H:i')
                                        : '-' }}
                                </td>

                                <td>
                                    <div class="product-name">
                                        {{ $movement->product?->product_name ?? 'Produk tidak tersedia' }}
                                    </div>

                                    <div class="sku">
                                        {{ $movement->product?->sku ?? '-' }}
                                    </div>
                                </td>

                                <td>
                                    @if ($movement->type === 'IN')
                                        <span class="badge badge-in">Barang Masuk</span>
                                    @else
                                        <span class="badge badge-out">Barang Keluar</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($movement->type === 'IN')
                                        <span class="quantity-in">
                                            +{{ number_format($movement->quantity) }}
                                        </span>
                                    @else
                                        <span class="quantity-out">
                                            -{{ number_format($movement->quantity) }}
                                        </span>
                                    @endif
                                </td>

                                <td>{{ number_format($movement->stock_before) }}</td>

                                <td>{{ number_format($movement->stock_after) }}</td>

                                <td>
                                    {{ $movement->user?->full_name
                                        ?: ($movement->user?->username ?? '-') }}
                                </td>

                                <td>
                                    {{ $movement->supplier?->supplier_name ?? '-' }}
                                </td>

                                <td>{{ $movement->notes ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="empty-state">
                                    Belum ada transaksi stok atau tidak ada transaksi
                                    yang sesuai dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                {{ $movements->links() }}
            </div>
        </section>
    </main>
</body>
</html>