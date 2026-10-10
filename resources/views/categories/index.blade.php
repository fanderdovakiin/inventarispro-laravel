<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori — InventarisPro</title>

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
            height: 68px;
            padding: 0 32px;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            color: #01498b;
            font-size: 19px;
            font-weight: 700;
            text-decoration: none;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 18px;
            font-size: 13px;
            color: #64748b;
        }

        main {
            max-width: 1180px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        .breadcrumb {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 22px;
        }

        .heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 26px;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 26px;
            letter-spacing: -.5px;
        }

        .subtitle {
            color: #64748b;
            margin: 0;
            font-size: 14px;
        }

        .button {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            min-height: 39px;
            padding: 9px 14px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            background: #fff;
            color: #334155;
            text-decoration: none;
            font: inherit;
            font-size: 13px;
            cursor: pointer;
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
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
            overflow: hidden;
        }

        .toolbar {
            padding: 18px 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
        }

        .search-form {
            display: flex;
            gap: 8px;
            width: min(100%, 440px);
        }

        input[type="search"] {
            flex: 1;
            min-width: 0;
            height: 40px;
            padding: 0 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            outline: none;
            font: inherit;
            font-size: 13px;
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
            padding: 12px 15px;
            margin-bottom: 18px;
            border-radius: 7px;
            font-size: 13px;
        }

        .alert-success {
            color: #166534;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            color: #991b1b;
            background: #fef2f2;
            border: 1px solid #fecaca;
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
            padding: 14px 18px;
            background: #f8fafc;
            color: #64748b;
            font-weight: 600;
            white-space: nowrap;
        }

        td {
            padding: 16px 18px;
            border-top: 1px solid #edf1f5;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #fafcff;
        }

        .category-name {
            color: #172b43;
            font-weight: 600;
        }

        .description {
            color: #64748b;
            max-width: 300px;
            line-height: 1.5;
        }

        .slug {
            color: #64748b;
            font-family: Consolas, monospace;
            font-size: 12px;
        }

        .product-count {
            display: inline-block;
            min-width: 28px;
            padding: 5px 8px;
            text-align: center;
            border-radius: 5px;
            color: #01498b;
            background: #eaf2fb;
            font-weight: 600;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .actions form {
            margin: 0;
        }

        .button-small {
            min-height: 32px;
            padding: 6px 10px;
            font-size: 12px;
        }

        .empty {
            text-align: center;
            padding: 48px 20px;
            color: #64748b;
            line-height: 1.7;
        }

        .empty strong {
            display: block;
            color: #334155;
            font-size: 15px;
            margin-bottom: 5px;
        }

        .pagination {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 13px;
        }

        .pagination-links {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .pagination a,
        .pagination span.page-current {
            display: inline-block;
            padding: 7px 10px;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            text-decoration: none;
            color: #334155;
        }

        .pagination span.page-current {
            color: #fff;
            background: #01498b;
            border-color: #01498b;
        }

        .logout {
            background: #fff;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 8px 12px;
            cursor: pointer;
            color: #334155;
        }

        @media (max-width: 650px) {
            header {
                padding: 0 16px;
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

            .header-actions {
                gap: 10px;
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
        <a href="{{ route('dashboard') }}" class="brand">
            InventarisPro
        </a>

        <div class="header-actions">
            <span>{{ auth()->user()->full_name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout">Keluar</button>
            </form>
        </div>
    </header>

    <main>
        <div class="breadcrumb">
            Dashboard / Data Master / Kategori
        </div>

        <div class="heading">
            <div>
                <h1>Kategori</h1>
                <p class="subtitle">
                    Kelola kategori untuk mengelompokkan produk inventory.
                </p>
            </div>

            @if (auth()->user()->isAdmin())
                <a href="{{ route('categories.create') }}" class="button button-primary">
                    + Tambah Kategori
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
                <form action="{{ route('categories.index') }}" method="GET" class="search-form">
                    <input type="search" name="search" placeholder="Cari nama kategori..."
                        value="{{ request('search') }}" aria-label="Cari kategori">

                    <button type="submit" class="button">
                        Cari
                    </button>

                    @if (request('search'))
                        <a href="{{ route('categories.index') }}" class="button">
                            Reset
                        </a>
                    @endif
                </form>

                <span class="count">
                    {{ $categories->total() }} kategori
                </span>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Slug</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Produk</th>
                            @if (auth()->user()->isAdmin())
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>
                                    <span class="category-name">
                                        {{ $category->category_name }}
                                    </span>
                                </td>

                                <td>
                                    <span class="slug">
                                        {{ $category->slug ?: '-' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="description">
                                        {{ $category->description ?: 'Tidak ada deskripsi' }}
                                    </div>
                                </td>

                                <td>
                                    <span class="product-count">
                                        {{ $category->products_count }}
                                    </span>
                                </td>

                                @if (auth()->user()->isAdmin())
                                    <td>
                                        <div class="actions">
                                            <a href="{{ route('categories.edit', $category) }}" class="button button-small">
                                                Edit
                                            </a>

                                            <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                                <td colspan="{{ auth()->user()->isAdmin() ? 5 : 4 }}" class="empty">
                                    <strong>
                                        @if (request('search'))
                                            Kategori tidak ditemukan
                                        @else
                                            Belum ada kategori
                                        @endif
                                    </strong>

                                    @if (request('search'))
                                        Coba kata kunci pencarian lainnya.
                                    @else
                                        Tambahkan kategori untuk mulai
                                        mengelompokkan produk.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($categories->hasPages())
                <div class="pagination">
                    <span>
                        Menampilkan {{ $categories->firstItem() ?? 0 }}
                        –{{ $categories->lastItem() ?? 0 }}
                        dari {{ $categories->total() }} kategori
                    </span>

                    <div class="pagination-links">
                        @if ($categories->onFirstPage())
                            <span>Sebelumnya</span>
                        @else
                            <a href="{{ $categories->previousPageUrl() }}">
                                Sebelumnya
                            </a>
                        @endif

                        @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                            @if ($page === $categories->currentPage())
                                <span class="page-current">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($categories->hasMorePages())
                            <a href="{{ $categories->nextPageUrl() }}">
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