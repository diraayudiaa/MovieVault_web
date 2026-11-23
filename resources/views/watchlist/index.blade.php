
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Watchlist - MovieVault</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 40px 20px;
            background: #0f172a;
            color: #f8fafc;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        h1 {
            margin: 0 0 10px;
            color: #a3e635;
        }

        .subtitle {
            color: #94a3b8;
            margin-bottom: 30px;
        }

        .back {
            display: inline-block;
            margin-bottom: 25px;
            color: #38bdf8;
            text-decoration: none;
        }

        .back:hover {
            text-decoration: underline;
        }

        .movie-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .movie-card {
            padding: 22px;
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
        }

        .movie-card h2 {
            margin-top: 0;
            font-size: 21px;
            color: #a3e635;
        }

        .movie-card p {
            color: #cbd5e1;
            line-height: 1.6;
        }

        .rating {
            color: #facc15 !important;
            font-weight: bold;
        }

        .date {
            color: #94a3b8 !important;
            font-size: 13px;
        }

        .actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .detail-link {
            display: inline-block;
            padding: 10px 14px;
            background: #0284c7;
            color: white;
            text-decoration: none;
            border-radius: 7px;
            font-size: 14px;
            font-weight: bold;
        }

        .detail-link:hover {
            background: #0369a1;
        }

        .delete-button {
            padding: 10px 14px;
            background: #dc2626;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .delete-button:hover {
            background: #b91c1c;
        }

        .success {
            padding: 13px 16px;
            margin-bottom: 20px;
            background: #14532d;
            color: #bbf7d0;
            border-radius: 8px;
        }

        .error {
            padding: 13px 16px;
            margin-bottom: 20px;
            background: #7f1d1d;
            color: #fecaca;
            border-radius: 8px;
        }

        .empty {
            padding: 30px;
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            color: #cbd5e1;
            text-align: center;
        }

        .empty a {
            color: #38bdf8;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            body {
                padding: 25px 15px;
            }
        }
    </style>
</head>

<body>
    @php
        $getText = function ($value) {
            if ($value instanceof \MongoDB\Model\BSONArray) {
                $value = $value->getArrayCopy();
            }

            if (is_array($value)) {
                return implode(', ', array_map(function ($item) {
                    return is_scalar($item) ? (string) $item : '';
                }, $value));
            }

            return is_scalar($value) ? (string) $value : '-';
        };
    @endphp

    <div class="container">

        <a href="{{ route('movies.index') }}" class="back">
            ← Kembali ke Katalog Film
        </a>

        <div class="header">
            <h1>My Watchlist</h1>
        </div>

        <p class="subtitle">
            Daftar film yang telah kamu simpan.
        </p>

        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="error">
                {{ session('error') }}
            </div>
        @endif

        @if (count($movies) > 0)

            <div class="movie-list">

                @foreach ($movies as $item)

                    @php
                        $movie = $item['movie'];
                        $movieId = (string) $movie['_id'];
                    @endphp

                    <div class="movie-card">

                        <h2>
                            {{ $getText($movie['title'] ?? 'Tanpa Judul') }}
                        </h2>

                        <p>
                            Genre:
                            {{ $getText($movie['genre'] ?? '-') }}
                        </p>

                        <p class="rating">
                            ★ {{ $getText($movie['rating'] ?? '-') }} / 10
                        </p>

                        <p class="date">
                            Ditambahkan: {{ $item['added_at'] }}
                        </p>

                        <div class="actions">

                            <a
                                href="{{ route('movies.show', $movieId) }}"
                                class="detail-link">
                                Lihat Detail
                            </a>

                            <form
                                action="{{ route('watchlist.destroy', $movieId) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus film ini dari Watchlist?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="delete-button">
                                    Hapus
                                </button>

                            </form>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="empty">
                <h3>Watchlist masih kosong</h3>

                <p>
                    Kamu belum menyimpan film apa pun.
                </p>

                <a href="{{ route('movies.index') }}">
                    Jelajahi Katalog Film
                </a>
            </div>

        @endif

    </div>
</body>
</html>
