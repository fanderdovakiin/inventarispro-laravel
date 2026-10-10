<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier — InventarisPro</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Inter, "Segoe UI", sans-serif;
            background: #f5f7fa;
            color: #172b43;
        }

        header {
            min-height: 68px;
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
        }

        .brand {
            color: #01498b;
            font-size: 19px;
            font-weight: 700;
            text-decoration: none;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #64748b;
            font-size: 13px;
        }

        .logout {
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: #fff;
            color: #334155;
            cursor: pointer;
        }

        main {
            max-width: 1320px;
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
            align-items: center;
            justify-content: space-between;
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
            min-height: 36px;
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: #fff;
            color: #334155;
            font: inherit;
            font-size: 12px;
            text-decoration: none;
            cursor: pointer;
            white-space: nowrap;
        }

        .button-primary {
            background: #01498b;
            border-color: #01498b;
            color: #fff;
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

        .panel {
            overflow: hidden;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
        }

        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            padding: 18px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .search-form {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            flex: 1;
        }

        input[type="search"] {
            width: min(100%, 350px);
            height: 40px;
            padding: 0 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font: inherit;
            font-size: 13px;
            outline: none;
        }

        input[type="search"]:focus {
            border-color: #01498b;
            box-shadow: 0 0 0 3px #01498b18;
        }

        .count {
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
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
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
            padding: 14px 17px;
            background: #f8fafc;
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        td {
            padding: 15px 17px;
            border-top: 1px solid #edf1f5;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #fafcff;
        }

        .supplier-name {
            display: block;
            margin-bottom: 5px;
            color: #172b43;
            font-weight: 600;
        }

        .muted {
            color: #64748b;
            font-size: 12px;
            line-height: 1.6;
        }

        .product-count {
            display: inline-block;
            min-width: 28px;
            padding: 5px 8px;
            border-radius: 5px;
            background: #eaf2fb;
            color: #01498b;
            font-weight: 600;
            text-align: center;
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
            margin-bottom: 5px;
            color: #334155;
            font-size: 15px;
        }

        .pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
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
            color: #fff;
        }

        @media (max-width: 650px) {
            header {
                padding: 14px 16px;
            }

            main {
                padding: 24px 14px;
            }

            .heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .toolbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .search-form {
                width: 100%;
            }

            input[type="search"] {
                flex: 1;
                width: auto;
            }

            .pagination {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <header>
        <a href="{{ route('dashboard') }}" class="brand">InventarisPro</a>

        <div class="header-right">
            <span>{{ auth()->user()->full_name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout">Keluar</button>
            </form>
        </div>
    </header>

    <main>
        <div class="breadcrumb">Dashboard / Data Master / Supplier</div>

        <div class="heading">
            <div>
                <h1>Supplier</h1>
                <p class="subtitle">
                    Kelola informasi pemasok dan hubungannya dengan produk.
                </p>
            </div>

            @if (auth()->user()->isAdmin())
                <a href="{{ route('suppliers.create') }}" class="button button-primary">
                    + Tambah Supplier
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
            <div class="toolbar">
                <form method="GET" action="{{ route('suppliers.index') }}" class="search-form">

                    <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama, email, atau telepon supplier..." aria-label="Cari supplier">

                    <button type="submit" class="button button-primary">
                        Cari
                    </button>

                    @if (request('search'))
                        <a href="{{ route('suppliers.index') }}" class="button">
                            Reset
                        </a>
                    @endif
                </form>

                <span class="count">
                    {{ $suppliers->total() }} supplier
                </span>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Supplier</th>
                            <th>Kontak</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                            <th>Alamat</th>
                            <th>Jumlah Produk</th>

                            @if (auth()->user()->isAdmin())
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($suppliers as $supplier)
                            <tr>
                                <td>
                                    <span class="supplier-name">
                                        {{ $supplier->supplier_name }}
                                    </span>

                                    <span class="muted">
                                        ID: {{ $supplier->supplier_id }}
                                    </span>
                                </td>

                                <td>
                                    {{ $supplier->contact_info ?: '-' }}
                                </td>

                                <td>
                                    {{ $supplier->email ?: '-' }}
                                </td>

                                <td>
                                    {{ $supplier->phone ?: '-' }}
                                </td>

                                <td>
                                    <span class="muted">
                                        {{ $supplier->location ?: '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="product-count">
                                        {{ $supplier->products_count }}
                                    </span>
                                </td>

                                @if (auth()->user()->isAdmin())
                                    <td>
                                        <div class="actions">
                                            <a href="{{ route('suppliers.edit', $supplier) }}" class="button">
                                                Edit
                                            </a>

                                            <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus supplier ini? Relasi pemasok akan dilepas sesuai aturan database.')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="button button-danger">
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
                                        @if (request('search'))
                                            Supplier tidak ditemukan
                                        @else
                                            Belum ada supplier
                                        @endif
                                    </strong>

                                    @if (request('search'))
                                        Coba kata kunci lainnya.
                                    @else
                                        Tambahkan supplier untuk mulai mengelola pemasok.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($suppliers->hasPages())
                <div class="pagination">
                    <span>
                        Menampilkan {{ $suppliers->firstItem() ?? 0 }}
                        –{{ $suppliers->lastItem() ?? 0 }}
                        dari {{ $suppliers->total() }} supplier
                    </span>

                    <div class="pagination-links">
                        @if ($suppliers->onFirstPage())
                            <span>Sebelumnya</span>
                        @else
                            <a href="{{ $suppliers->previousPageUrl() }}">
                                Sebelumnya
                            </a>
                        @endif

                        @foreach ($suppliers->getUrlRange(1, $suppliers->lastPage()) as $page => $url)
                            @if ($page === $suppliers->currentPage())
                                <span class="current">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($suppliers->hasMorePages())
                            <a href="{{ $suppliers->nextPageUrl() }}">
                                Berikutnya
                            </a>
                        @else
                            <span>Berikutnya</span>
                        @endif
                    </div>
                </div>
            @endif
        </section>
    </main>
</body>

</html>