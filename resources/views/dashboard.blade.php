@extends('layouts.app')

@section('title', 'Dashboard — InventarisPro')

@push('styles')
    <style>
        .heading {
            display: flex;
            justify-content: space-between;
            align-items: start;
            gap: 16px;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 26px;
            letter-spacing: -0.5px;
        }

        .subtitle {
            margin: 0;
            color: #64748b;
            font-size: 14px;
        }

        .role {
            display: inline-block;
            background: #eaf2fb;
            color: #01498b;
            border-radius: 5px;
            padding: 7px 10px;
            font-size: 12px;
            font-weight: 600;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 27px;
        }

        .card,
        .panel {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
        }

        .card {
            padding: 20px;
        }

        .card-label {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 13px;
        }

        .card-value {
            font-size: 27px;
            font-weight: 650;
            letter-spacing: -0.7px;
            overflow-wrap: anywhere;
        }

        .panel {
            overflow: hidden;
        }

        .panel-heading {
            padding: 19px 22px;
            border-bottom: 1px solid #e2e8f0;
        }

        .panel-heading h2 {
            font-size: 16px;
            margin: 0;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            text-align: left;
        }

        th {
            background: #f8fafc;
            color: #64748b;
            font-weight: 600;
        }

        th,
        td {
            padding: 14px 20px;
            border-bottom: 1px solid #edf1f5;
            white-space: nowrap;
        }

        tr:last-child td {
            border-bottom: 0;
        }

        .badge {
            display: inline-block;
            padding: 5px 8px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-in {
            background: #e8f7ee;
            color: #187344;
        }

        .badge-out {
            background: #fff0ed;
            color: #b93827;
        }

        .empty {
            padding: 30px;
            color: #64748b;
            text-align: center;
        }

        @media (max-width: 900px) {
            .cards {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            .heading {
                flex-direction: column;
                align-items: flex-start;
            }

            h1 {
                font-size: 22px;
            }

            .cards {
                grid-template-columns: minmax(0, 1fr);
            }

            .card-value {
                font-size: 24px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="heading">
        <div>
            <h1>Dashboard</h1>
            <p class="subtitle">
                Ringkasan kondisi persediaan barang.
            </p>
        </div>

        <span class="role">
            {{ strtoupper(auth()->user()->role) }}
        </span>
    </div>

    <section class="cards">
        <div class="card">
            <div class="card-label">Total Produk</div>
            <div class="card-value">{{ $totalProducts }}</div>
        </div>

        <div class="card">
            <div class="card-label">Nilai Persediaan</div>
            <div class="card-value">
                Rp {{ number_format((float) $totalValue, 0, ',', '.') }}
            </div>
        </div>

        <div class="card">
            <div class="card-label">Stok Rendah</div>
            <div class="card-value">{{ $lowStockCount }}</div>
        </div>

        <div class="card">
            <div class="card-label">Stok Habis</div>
            <div class="card-value">{{ $outOfStockCount }}</div>
        </div>
    </section>

    <section class="cards">
        <div class="card">
            <div class="card-label">Total Barang Masuk</div>
            <div class="card-value">{{ number_format($totalIn) }}</div>
        </div>

        <div class="card">
            <div class="card-label">Total Barang Keluar</div>
            <div class="card-value">{{ number_format($totalOut) }}</div>
        </div>
    </section>

    <section class="panel">
        <div class="panel-heading">
            <h2>Pergerakan Stok Terbaru</h2>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Stok Sesudah</th>
                        <th>Pengguna</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($recentMovements as $movement)
                        <tr>
                            <td>
                                {{ $movement->movement_date?->format('d/m/Y H:i') ?? '-' }}
                            </td>

                            <td>
                                {{ $movement->product?->product_name ?? 'Produk tidak ditemukan' }}
                            </td>

                            <td>
                                <span class="badge {{ $movement->type === 'IN' ? 'badge-in' : 'badge-out' }}">
                                    {{ $movement->type === 'IN' ? 'Masuk' : 'Keluar' }}
                                </span>
                            </td>

                            <td>{{ number_format($movement->quantity) }}</td>

                            <td>{{ number_format($movement->stock_after) }}</td>

                            <td>
                                {{ $movement->user?->full_name ?? 'Pengguna tidak ditemukan' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada histori pergerakan stok.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection