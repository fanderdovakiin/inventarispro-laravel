<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori — InventarisPro</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f5f7fa;
            color: #172b43;
            font-family: Inter, "Segoe UI", sans-serif;
        }

        header {
            height: 68px;
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

        .user-area {
            display: flex;
            align-items: center;
            gap: 16px;
            color: #64748b;
            font-size: 13px;
        }

        main {
            max-width: 920px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        .breadcrumb {
            margin-bottom: 22px;
            color: #64748b;
            font-size: 13px;
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

        .form-panel {
            margin-top: 25px;
            padding: 28px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
        }

        .panel-title {
            margin: 0 0 8px;
            font-size: 16px;
        }

        .panel-description {
            margin: 0 0 26px;
            color: #64748b;
            font-size: 13px;
            line-height: 1.6;
        }

        .field {
            margin-bottom: 22px;
        }

        label {
            display: block;
            margin-bottom: 9px;
            font-size: 13px;
            font-weight: 600;
        }

        .required {
            color: #b42318;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font: inherit;
            font-size: 14px;
            outline: none;
            background: #fff;
        }

        input[type="text"] {
            height: 44px;
        }

        textarea {
            resize: vertical;
            min-height: 110px;
            line-height: 1.6;
        }

        input:focus,
        textarea:focus {
            border-color: #01498b;
            box-shadow: 0 0 0 3px #01498b18;
        }

        .field-error {
            display: block;
            margin-top: 7px;
            color: #b42318;
            font-size: 12px;
        }

        .alert {
            margin-bottom: 20px;
            padding: 12px 14px;
            border-radius: 6px;
            font-size: 13px;
            line-height: 1.7;
        }

        .alert-error {
            color: #991b1b;
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 22px;
            border-top: 1px solid #edf1f5;
        }

        .button {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            min-height: 40px;
            padding: 10px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font: inherit;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
        }

        .button-secondary {
            background: #fff;
            color: #334155;
        }

        .button-primary {
            border-color: #01498b;
            background: #01498b;
            color: #fff;
        }

        .button-primary:hover {
            background: #003b72;
        }

        .logout {
            padding: 8px 12px;
            color: #334155;
            background: #fff;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            cursor: pointer;
        }

        @media (max-width: 600px) {
            header {
                padding: 0 16px;
            }

            main {
                padding: 24px 14px;
            }

            .form-panel {
                padding: 20px;
            }

            h1 {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>
    <header>
        <a href="{{ route('dashboard') }}" class="brand">InventarisPro</a>

        <div class="user-area">
            <span>{{ auth()->user()->full_name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout">Keluar</button>
            </form>
        </div>
    </header>

    <main>
        <div class="breadcrumb">
            Dashboard / Data Master / Kategori / Tambah
        </div>

        <h1>Tambah Kategori</h1>

        <p class="subtitle">
            Tambahkan kategori baru untuk mengelompokkan produk.
        </p>

        <section class="form-panel">
            <h2 class="panel-title">Informasi Kategori</h2>

            <p class="panel-description">
                Isi nama kategori. Deskripsi dapat ditambahkan sebagai informasi tambahan.
            </p>

            @include('categories._form', ['category' => null])
        </section>
    </main>
</body>

</html>