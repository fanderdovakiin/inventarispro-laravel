@extends('layouts.app')

@section('title', 'Riwayat Stok — InventarisPro')

@push('styles')
<style>
    .page-main {
        max-width: 1450px;
        margin: 0 auto;
        padding: 32px 24px;
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

    .filter-grid input,
    .filter-grid select {
        width: 100%;
        min-width: 0;
        min-height: 42px;
        padding: 11px 12px;
        border: 1px solid #d5dce5;
        border-radius: 8px;
        background: white;
        font: inherit;
        font-size: 14px;
        color: #243247;
    }

    .filter-grid input:focus,
    .filter-grid select:focus {
        outline: none;
        border-color: #01498b;
        box-shadow: 0 0 0 3px rgba(1, 73, 139, .1);
    }

    .filter-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
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

    .table-wrapper table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 1000px;
    }

    .table-wrapper thead {
        background: #f6f8fb;
    }

    .table-wrapper th {
        color: #536176;
        font-weight: 600;
        text-align: left;
        white-space: nowrap;
    }

    .table-wrapper th,
    .table-wrapper td {
        padding: 14px 12px;
        border-bottom: 1px solid #e9edf3;
        vertical-align: top;
    }

    .table-wrapper tbody tr:hover {
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
        white-space: nowrap;
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
        padding: 38px 15px !important;
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
        .page-main {
            padding: 24px 14px;
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
@endpush

@section('content')
    <nav class="stock-nav" aria-label="Navigasi stok">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('products.index') }}">Produk</a>
        <a href="{{ route('stock.in.create') }}">Barang Masuk</a>
        <a href="{{ route('stock.out.create') }}">Barang Keluar</a>
        <a href="{{ route('stock.history') }}" class="active">Riwayat Stok</a>
    </nav>

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

                        <option
                            value="IN"
                            @selected(($filters['type'] ?? '') === 'IN')
                        >
                            Barang Masuk
                        </option>

                        <option
                            value="OUT"
                            @selected(($filters['type'] ?? '') === 'OUT')
                        >
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

            <div class="filter-actions">
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
@endsection