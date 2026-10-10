@extends('layouts.app')

@section('title', $pageTitle . ' — InventarisPro')

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
            color: #64748b;
            font-size: 13px;
            line-height: 1.6;
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
        textarea {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: white;
            color: #172b43;
            font: inherit;
            font-size: 14px;
            outline: none;
        }

        input {
            height: 44px;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
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
            border-radius: 7px;
            font-size: 13px;
            line-height: 1.7;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
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
        Dashboard / Data Master / Supplier / {{ $pageTitle }}
    </div>

    <h1>{{ $pageTitle }}</h1>

    <p class="subtitle">
        {{ $supplier
        ? 'Perbarui informasi supplier yang sudah terdaftar.'
        : 'Tambahkan pemasok baru ke dalam sistem inventory.' }}
    </p>

    <section class="panel">
        <h2>Informasi Supplier</h2>

        <p class="panel-description">
            Nama supplier wajib diisi. Informasi kontak lainnya dapat dilengkapi jika tersedia.
        </p>

        @include('suppliers._form', ['supplier' => $supplier])
    </section>
@endsection