<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'InventarisPro')</title>

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

        .site-header {
            min-height: 70px;
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .brand {
            font-size: 18px;
            font-weight: 700;
            color: #01498b;
            text-decoration: none;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 18px;
            color: #64748b;
            font-size: 13px;
        }

        .logout {
            border: 1px solid #cbd5e1;
            background: white;
            color: #334155;
            border-radius: 6px;
            padding: 9px 13px;
            cursor: pointer;
            font: inherit;
        }

        .logout:hover {
            background: #f8fafc;
        }

        .page-main {
            max-width: 1200px;
            padding: 32px;
            margin: 0 auto;
        }

        @media (max-width: 600px) {
            .site-header {
                padding: 12px 16px;
            }

            .header-right {
                gap: 8px;
            }

            .page-main {
                padding: 22px 16px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <header class="site-header">
        <a href="{{ route('dashboard') }}" class="brand">
            InventarisPro
        </a>

        <div class="header-right">
            @auth
                <span>
                    {{ auth()->user()->full_name ?: auth()->user()->username }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button class="logout" type="submit">
                        Keluar
                    </button>
                </form>
            @endauth
        </div>
    </header>

    <main class="page-main">
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>