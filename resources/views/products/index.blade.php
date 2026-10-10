@extends('layouts.app')

@section('title', 'Produk — InventarisPro')

@push('styles')
    <style>
        .page-main {
            max-width: 1360px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        .breadcrumb {
            margin-bottom: 22px;
            color: #64748b;
            font-size: 13px;
        }

        .heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 26px;
            letter-spacing: -.5px;
        }

        .subtitle {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 38px;
            padding: 9px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: #fff;
            color: #334155;
            font: inherit;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
            white-space: nowrap;
        }

        .button-primary {
            background: #01498b;
            border-color: #01498b;
            color: white;
        }

        .button-primary:hover {
            background: #003b72;
        }

        .button-danger {
            color: #b42318;
            border-color: #fecaca;
        }

        .button-danger:hover {
            background: #fef2f2;
        }

        .button-small {
            min-height: 31px;
            padding: 6px 9px;
            font-size: 12px;
        }

        .panel {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
            overflow: hidden;
        }

        .filters {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            padding: 18px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .filter-form {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            flex: 1;
        }

        .filter-form input,
        .filter-form select {
            height: 40px;
            padding: 0 11px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: white;
            color: #334155;
            font: inherit;
            font-size: 13px;
            outline: none;
        }

        .filter-form input[name="search"] {
            width: min(100%, 290px);
        }

        .filter-form select {
            max-width: 220px;
        }

        .filter-form input:focus,
        .filter-form select:focus {
            border-color: #01498b;
            box-shadow: 0 0 0 3px #01498b18;
        }

        .result-count {
            color: #64748b;
            font-size: 13px;
            white-space: nowrap;
        }

        .alert {
            margin-bottom: 18px;
            padding: 12px 15px;
            border-radius: 7px;
            font-size: 13px;
            line-height: 1.6;
        }

        .alert-success {
            border: 1px solid #bbf7d0;
            background: #f0fdf4;
            color: #166534;
        }

        .alert-error {
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #991b1b;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
        }

        th {
            background: #f8fafc;
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        th,
        td {
            padding: 14px 16px;
            border-bottom: 1px solid #edf1f5;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #fafcff;
        }

        tbody tr:last-child td {
            border-bottom: 0;
        }

        .sort-link {
            color: inherit;
            text-decoration: none;
        }

        .sort-link:hover {
            color: #01498b;
        }

        .product-name {
            display: block;
            font-weight: 600;
            color: #172b43;
            margin-bottom: 4px;
        }

        .sku {
            font-family: Consolas, monospace;
            font-size: 11px;
            color: #64748b;
        }

        .muted {
            color: #64748b;
            font-size: 12px;
        }

        .price {
            font-weight: 600;
            white-space: nowrap;
        }

        .status {
            display: inline-block;
            padding: 5px 8px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-safe {
            background: #e8f7ee;
            color: #187344;
        }

        .status-low {
            background: #fff7df;
            color: #8a5a00;
        }

        .status-out {
            background: #fff0ed;
            color: #b93827;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .actions form {
            margin: 0;
        }

        .empty {
            padding: 45px 20px;
            text-align: center;
            color: #64748b;
            line-height: 1.7;
        }

        .empty strong {
            display: block;
            color: #334155;
            margin-bottom: 5px;
            font-size: 15px;
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            padding: 16px 20px;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 12px;
        }

        .pagination-links {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 5px;
        }

        .pagination-links a,
        .pagination-links span {
            padding: 7px 10px;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            color: #334155;
            text-decoration: none;
        }

        .pagination-links .current {
            background: #01498b;
            border-color: #01498b;
            color: white;
        }

        .footer-note {
            color: #64748b;
            font-size: 12px;
            margin-top: 14px;
        }

        @media (max-width: 760px) {
            .page-main {
                padding: 24px 14px;
            }

            .heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .filters {
                align-items: flex-start;
                flex-direction: column;
            }

            .filter-form {
                width: 100%;
            }

            .filter-form input[name="search"] {
                flex: 1;
                width: auto;
                min-width: 120px;
            }

            .filter-form select {
                max-width: 100%;
            }

            .pagination {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
@endpush

@section('content')
    <div class="breadcrumb">Dashboard / Data Master / Produk</div>

    <div class="heading">
        <div>
            <h1>Produk</h1>
            <p class="subtitle">
                Kelola data barang dan pantau ketersediaan stok.
            </p>
        </div>

        @if (auth()->user()->isAdmin())
            <a href="{{ route('products.create') }}" class="button button-primary">
                + Tambah Produk
            </a>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="status">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error" role="alert">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <section class="panel">
        <div class="filters">
            <form method="GET" action="{{ route('products.index') }}" class="filter-form">

                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama produk atau SKU..." aria-label="Cari produk">

                <select name="category_id" aria-label="Filter kategori">
                    <option value="">Semua kategori</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}" @selected(
                            (string) request('category_id')
                            === (string) $category->category_id
                        )>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="button button-primary">
                    Terapkan
                </button>

                @if (request()->query())
                    <a href="{{ route('products.index') }}" class="button">
                        Reset
                    </a>
                @endif
            </form>

            <span class="result-count">
                {{ $products->total() }} produk
            </span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>
                            <a class="sort-link" href="{{ route('products.index', array_merge(request()->query(), [
        'sort' => 'product_name',
        'direction' => $sort === 'product_name' && $direction === 'asc' ? 'desc' : 'asc',
        'page' => 1,
    ])) }}">
                                Produk
                                @if ($sort === 'product_name')
                                    {{ $direction === 'asc' ? '↑' : '↓' }}
                                @endif
                            </a>
                        </th>

                        <th>Kategori</th>
                        <th>Pemasok</th>

                        <th>
                            <a class="sort-link" href="{{ route('products.index', array_merge(request()->query(), [
        'sort' => 'price',
        'direction' => $sort === 'price' && $direction === 'asc' ? 'desc' : 'asc',
        'page' => 1,
    ])) }}">
                                Harga
                                @if ($sort === 'price')
                                    {{ $direction === 'asc' ? '↑' : '↓' }}
                                @endif
                            </a>
                        </th>

                        <th>
                            <a class="sort-link" href="{{ route('products.index', array_merge(request()->query(), [
        'sort' => 'stock',
        'direction' => $sort === 'stock' && $direction === 'asc' ? 'desc' : 'asc',
        'page' => 1,
    ])) }}">
                                Stok
                                @if ($sort === 'stock')
                                    {{ $direction === 'asc' ? '↑' : '↓' }}
                                @endif
                            </a>
                        </th>

                        <th>Status</th>

                        @if (auth()->user()->isAdmin())
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                <span class="product-name">
                                    {{ $product->product_name }}
                                </span>

                                <span class="sku">
                                    {{ $product->sku }}
                                </span>
                            </td>

                            <td>
                                {{ $product->category?->category_name ?? 'Tanpa kategori' }}
                            </td>

                            <td>
                                @forelse ($product->suppliers as $supplier)
                                    <div>
                                        {{ $supplier->supplier_name }}

                                        @if ($supplier->pivot->is_primary)
                                            <span class="muted">(Utama)</span>
                                        @endif
                                    </div>
                                @empty
                                    <span class="muted">Belum ditentukan</span>
                                @endforelse
                            </td>

                            <td class="price">
                                Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ number_format($product->stock) }}
                                <div class="muted">
                                    Minimum: {{ $product->minimum_stock }}
                                </div>
                            </td>

                            <td>
                                @if ($product->stock == 0)
                                    <span class="status status-out">
                                        Stok Habis
                                    </span>
                                @elseif ($product->isLowStock())
                                    <span class="status status-low">
                                        Stok Rendah
                                    </span>
                                @else
                                    <span class="status status-safe">
                                        Stok Aman
                                    </span>
                                @endif
                            </td>

                            @if (auth()->user()->isAdmin())
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('products.edit', $product) }}" class="button button-small">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('products.destroy', $product) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus produk ini? Produk yang memiliki histori stok tidak dapat dihapus.')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="button button-small button-danger">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? 7 : 6 }}" class="empty">
                                <strong>
                                    @if (request('search') || request('category_id'))
                                        Produk tidak ditemukan
                                    @else
                                        Belum ada produk
                                    @endif
                                </strong>

                                @if (request('search') || request('category_id'))
                                    Coba ubah kata kunci atau filter kategori.
                                @else
                                    Belum ada data produk yang dapat ditampilkan.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="pagination">
                <span>
                    Menampilkan {{ $products->firstItem() ?? 0 }}
                    –{{ $products->lastItem() ?? 0 }}
                    dari {{ $products->total() }} produk
                </span>

                <div class="pagination-links">
                    @if ($products->onFirstPage())
                        <span>Sebelumnya</span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}">
                            Sebelumnya
                        </a>
                    @endif

                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if ($page === $products->currentPage())
                            <span class="current">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}">
                            Berikutnya
                        </a>
                    @else
                        <span>Berikutnya</span>
                    @endif
                </div>
            </div>
        @endif
    </section>

    <p class="footer-note">
        Perubahan stok hanya dilakukan melalui transaksi barang masuk dan barang keluar.
    </p>
@endsection