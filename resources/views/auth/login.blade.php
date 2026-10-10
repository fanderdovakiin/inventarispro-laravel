<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — InventarisPro</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, "Segoe UI", sans-serif;
            color: #172b43;
            background: #f5f7fa;
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .login-shell {
            width: min(100%, 960px);
            min-height: 570px;
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }

        .brand-panel {
            background: #01498b;
            color: #fff;
            padding: 44px 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 19px;
            font-weight: 700;
        }

        .brand-mark {
            width: 40px;
            height: 40px;
            border: 1px solid #ffffff55;
            border-radius: 9px;
            display: grid;
            place-items: center;
        }

        .brand-mark svg {
            width: 23px;
            height: 23px;
        }

        .brand-copy h1 {
            font-size: 30px;
            line-height: 1.3;
            letter-spacing: -0.8px;
            margin: 0 0 14px;
        }

        .brand-copy p {
            color: #d7e6f6;
            line-height: 1.8;
            font-size: 14px;
            margin: 0;
        }

        .brand-footer {
            font-size: 12px;
            color: #d7e6f6;
        }

        .form-panel {
            padding: 64px 54px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .eyebrow {
            color: #64748b;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1.2px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .form-panel h2 {
            margin: 0 0 8px;
            color: #132941;
            font-size: 27px;
            letter-spacing: -0.6px;
        }

        .intro {
            margin: 0 0 30px;
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
        }

        .field {
            margin-bottom: 19px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            height: 46px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            padding: 0 13px;
            font: inherit;
            font-size: 14px;
            outline: none;
            background: white;
        }

        input:focus {
            border-color: #01498b;
            box-shadow: 0 0 0 3px #01498b18;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #475569;
            font-size: 13px;
            margin: 2px 0 23px;
        }

        .remember input {
            accent-color: #01498b;
        }

        .submit {
            width: 100%;
            height: 47px;
            border: 0;
            border-radius: 7px;
            background: #01498b;
            color: white;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .submit:hover {
            background: #003b72;
        }

        .error-box {
            margin-bottom: 20px;
            padding: 12px 14px;
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #b91c1c;
            border-radius: 7px;
            font-size: 13px;
            line-height: 1.6;
        }

        .field-error {
            color: #b91c1c;
            font-size: 12px;
            margin-top: 6px;
        }

        .form-footer {
            margin-top: 27px;
            color: #94a3b8;
            font-size: 12px;
            line-height: 1.6;
        }

        @media (max-width: 700px) {
            body {
                padding: 12px;
            }

            .login-shell {
                grid-template-columns: 1fr;
            }

            .brand-panel {
                padding: 25px;
                gap: 24px;
            }

            .brand-copy h1 {
                font-size: 23px;
            }

            .brand-footer {
                display: none;
            }

            .form-panel {
                padding: 34px 25px;
            }
        }
    </style>
</head>

<body>
    <main class="login-shell">
        <section class="brand-panel">
            <div class="brand">
                <div class="brand-mark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                        <path d="m4 7 8-4 8 4-8 4-8-4Z" />
                        <path d="M4 7v10l8 4 8-4V7" />
                        <path d="M12 11v10" />
                    </svg>
                </div>

                <span>InventarisPro</span>
            </div>

            <div class="brand-copy">
                <h1>Pengelolaan stok yang lebih teratur.</h1>
                <p>
                    Pantau persediaan, catat pergerakan barang,
                    dan kelola data inventory dalam satu tempat.
                </p>
            </div>

            <div class="brand-footer">
                Inventory Management System
            </div>
        </section>

        <section class="form-panel">
            <div class="eyebrow">Inventory Management System</div>

            <h2>Masuk ke akun</h2>

            <p class="intro">
                Masukkan username dan password untuk melanjutkan.
            </p>

            @if ($errors->any())
                <div class="error-box" role="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label for="username">Username</label>

                    <input type="text" id="username" name="username" value="{{ old('username') }}"
                        autocomplete="username" required autofocus>

                    @error('username')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>

                    <input type="password" id="password" name="password" autocomplete="current-password" required>

                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <label class="remember">
                    <input type="checkbox" name="remember" value="1">
                    Ingat saya
                </label>

                <button class="submit" type="submit">
                    Masuk ke dashboard
                </button>
            </form>

            <div class="form-footer">
                Akses aplikasi hanya untuk pengguna yang memiliki akun.
            </div>
        </section>
    </main>
</body>

</html>