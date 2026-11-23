
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MovieVault</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #101827;
            color: white;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            max-width: 430px;
            padding: 32px;
            background: #1c293b;
            border: 1px solid #34445a;
            border-radius: 14px;
        }

        h1 {
            color: #a3e635;
            text-align: center;
        }

        .subtitle {
            color: #aab4c5;
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin: 15px 0 7px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #475569;
            border-radius: 7px;
            background: #101827;
            color: white;
        }

        button {
            width: 100%;
            margin-top: 24px;
            padding: 13px;
            border: none;
            border-radius: 7px;
            background: #a3e635;
            color: #101827;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #bef264;
        }

        .link {
            text-align: center;
            margin-top: 20px;
            color: #cbd5e1;
        }

        a {
            color: #38bdf8;
            text-decoration: none;
        }

        .error {
            color: #fca5a5;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>MovieVault</h1>
        <p class="subtitle">Login untuk melanjutkan ke akunmu.</p>

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <label>Username atau Email</label>
            <input
                type="text"
                name="login"
                value="{{ old('login') }}"
                placeholder="Masukkan username atau email"
                required
            >
            @error('login')
                <div class="error">{{ $message }}</div>
            @enderror

            <label>Password</label>
            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
            >
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit">Login</button>
        </form>

        <p class="link">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar sekarang</a>
        </p>
    </div>
</body>
</html>
