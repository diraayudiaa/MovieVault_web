
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MovieVault</title>

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
        <p class="subtitle">Buat akun baru untuk bergabung.</p>

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <label>Nama Lengkap</label>
            <input
                type="text"
                name="full_name"
                value="{{ old('full_name') }}"
                required
            >
            @error('full_name')
                <div class="error">{{ $message }}</div>
            @enderror

            <label>Username</label>
            <input
                type="text"
                name="username"
                value="{{ old('username') }}"
                required
            >
            @error('username')
                <div class="error">{{ $message }}</div>
            @enderror

            <label>Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
            >
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <label>Password</label>
            <input
                type="password"
                name="password"
                required
            >
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <label>Konfirmasi Password</label>
            <input
                type="password"
                name="password_confirmation"
                required
            >

            <button type="submit">Daftar</button>
        </form>

        <p class="link">
            Sudah punya akun?
            <a href="{{ route('login') }}">Login</a>
        </p>
    </div>
</body>
</html>
