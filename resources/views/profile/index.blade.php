
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - MovieVault</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            padding: 40px 20px;
            background: #101827;
            color: white;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 650px;
            margin: auto;
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
            margin-bottom: 30px;
        }

        .profile-info {
            padding: 18px;
            margin-bottom: 25px;
            background: #101827;
            border-radius: 9px;
        }

        .profile-info p {
            color: #cbd5e1;
            margin: 10px 0;
        }

        label {
            display: block;
            margin: 15px 0 7px;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #475569;
            border-radius: 7px;
            background: #101827;
            color: white;
            font-family: Arial, sans-serif;
        }

        textarea {
            resize: vertical;
            min-height: 90px;
        }

        button {
            width: 100%;
            margin-top: 22px;
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

        .logout-button {
            background: #ef4444;
            color: white;
        }

        .logout-button:hover {
            background: #dc2626;
        }

        .links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 25px 0;
            flex-wrap: wrap;
        }

        a {
            color: #38bdf8;
            text-decoration: none;
        }

        .message {
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 7px;
            background: #365314;
            color: #d9f99d;
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
        <h1>My Profile</h1>
        <p class="subtitle">Kelola informasi akun MovieVault kamu.</p>

        @if (session('success'))
            <div class="message">
                {{ session('success') }}
            </div>
        @endif

        <div class="profile-info">
            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Role:</strong> {{ $user->role }}</p>
        </div>

        <h3>Edit Profile</h3>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <label>Nama Lengkap</label>
            <input
                type="text"
                name="full_name"
                value="{{ old('full_name', $user->full_name) }}"
                required
            >
            @error('full_name')
                <div class="error">{{ $message }}</div>
            @enderror

            <label>Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                required
            >
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <label>Bio</label>
            <textarea name="bio">{{ old('bio', $user->bio) }}</textarea>
            @error('bio')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit">Simpan Perubahan</button>
        </form>

        <div class="links">
            <a href="{{ route('movies.index') }}">Daftar Film</a>
            <a href="{{ route('watchlist.index') }}">My Watchlist</a>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>
</body>
</html>
