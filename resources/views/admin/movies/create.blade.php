<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Film - MovieVault</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 35px 20px;
            font-family: Arial, sans-serif;
            background: #101827;
            color: #f1f5f9;
        }

        .container {
            max-width: 750px;
            margin: auto;
        }

        .logo {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .logo span {
            color: #a3e635;
        }

        .form-card {
            background: #1b293b;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #29394e;
        }

        h1 {
            margin-top: 0;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #94a3b8;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 9px;
            font-size: 14px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 13px;
            border: 1px solid #475569;
            border-radius: 7px;
            background: #101827;
            color: white;
            font-family: Arial, sans-serif;
            font-size: 14px;
            outline: none;
        }

        input:focus, textarea:focus {
            border-color: #a3e635;
        }

        textarea {
            resize: vertical;
            min-height: 110px;
        }

        .hint {
            color: #94a3b8;
            font-size: 12px;
            margin-top: 7px;
        }

        .error {
            color: #fca5a5;
            font-size: 13px;
            margin-top: 7px;
        }

        .alert {
            background: #451f27;
            color: #fecaca;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        button, .back-button {
            padding: 13px 20px;
            border-radius: 8px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        button {
            background: #a3e635;
            color: #101827;
        }

        .back-button {
            background: #334155;
            color: white;
        }

        @media(max-width: 600px) {
            .form-card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="logo">MOVIE<span>VAULT</span></div>

    <div class="form-card">

        <h1>Tambah Film Baru</h1>

        <p class="subtitle">
            Masukkan informasi film yang ingin ditambahkan ke MovieVault.
        </p>

        @if($errors->any())
            <div class="alert">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.movies.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="title">Judul Film</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Contoh: Interstellar"
                    required
                >
            </div>

            <div class="form-group">
                <label for="genre">Genre Film</label>
                <input
                    type="text"
                    id="genre"
                    name="genre"
                    value="{{ old('genre') }}"
                    placeholder="Contoh: Sci-Fi, Adventure, Drama"
                    required
                >
                <div class="hint">Pisahkan setiap genre menggunakan koma.</div>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Film</label>
                <textarea
                    id="description"
                    name="description"
                    placeholder="Masukkan sinopsis film..."
                    required
                >{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="release_year">Tahun Rilis</label>
                <input
                    type="number"
                    id="release_year"
                    name="release_year"
                    value="{{ old('release_year') }}"
                    placeholder="Contoh: 2024"
                    min="1888"
                    max="{{ date('Y') + 5 }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="director">Sutradara</label>
                <input
                    type="text"
                    id="director"
                    name="director"
                    value="{{ old('director') }}"
                    placeholder="Nama sutradara"
                    required
                >
            </div>

            <div class="form-group">
                <label for="cast">Pemeran</label>
                <textarea
                    id="cast"
                    name="cast"
                    placeholder="Contoh: Matthew McConaughey, Anne Hathaway"
                    required
                >{{ old('cast') }}</textarea>
                <div class="hint">Pisahkan nama pemeran menggunakan koma.</div>
            </div>

            <div class="actions">
                <button type="submit">Simpan Film</button>

                <a href="{{ route('admin.index') }}" class="back-button">
                    Kembali
                </a>
            </div>

        </form>

    </div>

</div>

</body>
</html>
