@extends('layouts.app')

@section('title', 'Tambah Produk — InventarisPro')

@push('styles')
    <style>
        .page-main {
            max-width: 960px;
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

        .panel {
            margin-top: 25px;
            padding: 28px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
        }

        .panel h2 {
            margin: 0 0 8px;
            font-size: 16px;
        }

        .panel-description {
            margin: 0 0 26px;
            font-size: 13px;
            line-height: 1.6;
            color: #64748b;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px 18px;
        }

        .field {
            min-width: 0;
        }

        .field-full {
            grid-column: 1 / -1;
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

        input,
        select,
        textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: white;
            color: #172b43;
            padding: 11px 12px;
            font: inherit;
            font-size: 14px;
            outline: none;
        }

        input,
        select {
            height: 44px;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
            line-height: 1.6;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #01498b;
            box-shadow: 0 0 0 3px #01498b18;
        }

        .field-error {
            display: block;
            margin-top: 7px;
            font-size: 12px;
            color: #b42318;
        }

        .alert {
            padding: 12px 14px;
            margin-bottom: 20px;
            border-radius: 7px;
            font-size: 13px;
            line-height: 1.7;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .stock-note {
            margin-top: 24px;
            padding: 13px 15px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.7;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 24px;
            padding-top: 22px;
            border-top: 1px solid #edf1f5;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
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
            background: white;
            color: #334155;
        }

        .button-primary {
            background: #01498b;
            color: white;
            border-color: #01498b;
        }

        .button-primary:hover {
            background: #003b72;
        }

        @media (max-width: 600px) {
            .page-main {
                padding: 24px 14px;
            }

            .panel {
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .field-full {
                grid-column: auto;
            }

            h1 {
                font-size: 23px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="breadcrumb">
        Dashboard / Data Master / Produk / Tambah
    </div>

    <h1>Tambah Produk</h1>

    <p class="subtitle">
        Masukkan informasi produk yang akan didaftarkan ke inventory.
    </p>

    <section class="panel">
        <h2>Informasi Produk</h2>

        <p class="panel-description">
            Lengkapi kode produk, nama, kategori, harga, dan batas minimum stok.
        </p>

        @include('products._form', ['product' => null])
    </section>
@endsection