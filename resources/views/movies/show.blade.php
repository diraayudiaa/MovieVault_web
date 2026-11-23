<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Film - MovieVault</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 40px 20px;
            font-family: Arial, sans-serif;
            background: #101827;
            color: white;
        }

        .container {
            max-width: 850px;
            margin: auto;
        }

        .movie-detail,
        .review-section {
            background: #1c293b;
            border: 1px solid #34445a;
            border-radius: 14px;
            padding: 35px;
            margin-bottom: 25px;
        }

        h1, h2 {
            color: #a3e635;
            margin-top: 0;
        }

        h1 {
            font-size: 32px;
        }

        h2 {
            font-size: 25px;
        }

        .genre {
            color: #93c5fd;
        }

        .rating {
            color: #facc15;
            font-size: 22px;
            font-weight: bold;
        }

        .description {
            color: #cbd5e1;
            line-height: 1.8;
            margin: 25px 0;
        }

        .info {
            color: #cbd5e1;
            line-height: 1.8;
        }

        .back-button {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 20px;
            background: #a3e635;
            color: #101827;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .back-button:hover {
            background: #bef264;
        }

        .average-rating {
            color: #facc15;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .review-card {
            background: #26364b;
            border: 1px solid #3b4c63;
            padding: 20px;
            border-radius: 9px;
            margin-bottom: 15px;
        }

        .review-user {
            color: #a3e635;
            font-weight: bold;
        }

        .review-rating {
            color: #facc15;
            font-weight: bold;
        }

        .review-comment {
            color: #cbd5e1;
            line-height: 1.7;
            overflow-wrap: anywhere;
        }

        .review-date {
            color: #94a3b8;
            font-size: 12px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #e2e8f0;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border-radius: 7px;
            border: 1px solid #475569;
            background: #101827;
            color: white;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .submit-button {
            padding: 13px 22px;
            background: #a3e635;
            color: #101827;
            border: none;
            border-radius: 7px;
            font-weight: bold;
            cursor: pointer;
        }

        .submit-button:hover {
            background: #bef264;
        }

        .alert {
            padding: 13px 16px;
            border-radius: 7px;
            margin-bottom: 18px;
        }

        .success {
            background: #14532d;
            color: #bbf7d0;
        }

        .error {
            background: #7f1d1d;
            color: #fecaca;
        }

        .info-message {
            color: #cbd5e1;
            line-height: 1.7;
        }

        .login-link {
            color: #a3e635;
            font-weight: bold;
        }

        .empty-review {
            color: #94a3b8;
            padding: 15px 0;
        }

        @media (max-width: 600px) {
            body {
                padding: 20px 12px;
            }

            .movie-detail,
            .review-section {
                padding: 22px;
            }

            h1 {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>

    @php
        $getText = function ($value) {
            if (
                $value instanceof \MongoDB\Model\BSONArray ||
                $value instanceof \MongoDB\Model\BSONDocument
            ) {
                $value = $value->getArrayCopy();
            }

            if ($value instanceof \Traversable) {
                $value = iterator_to_array($value);
            }

            if (is_array($value)) {
                return implode(', ', array_filter(array_map(
                    function ($item) {
                        return is_scalar($item) ? (string) $item : '';
                    },
                    $value
                )));
            }

            if (is_scalar($value)) {
                return (string) $value;
            }

            return '-';
        };
    @endphp

    <div class="container">

        <!-- DETAIL FILM -->
        <div class="movie-detail">

            <h1>{{ $getText($movie['title'] ?? null) }}</h1>

            <p class="genre">
                Genre:
                {{ $getText($movie['genre'] ?? $movie['genres'] ?? null) }}
            </p>

            <p class="rating">
                @if ($reviewCount > 0)
                    ★ {{ $averageReviewRating }}/10
                @else
                    Belum ada rating
                @endif
            </p>

            <p class="description">
                {{ $getText($movie['description'] ?? null) }}
            </p>

            <div class="info">
                <p>
                    <strong>Tahun Rilis:</strong>
                    {{ $getText($movie['release_year'] ?? $movie['year'] ?? null) }}
                </p>

                <p>
                    <strong>Director:</strong>
                    {{ $getText($movie['director'] ?? null) }}
                </p>

                <p>
                    <strong>Cast:</strong>
                    {{ $getText($movie['cast'] ?? null) }}
                </p>
            </div>

            <a href="{{ route('movies.index') }}" class="back-button">
                ← Kembali ke Movies
            </a>

        </div>

        <!-- REVIEW FILM -->
        <div class="review-section">

            <h2>Reviews</h2>

            <div class="average-rating">
                @if ($reviewCount > 0)
                    ★ {{ $averageReviewRating }}/10

                    <span style="color:#94a3b8;font-size:14px;font-weight:normal;">
                        ({{ $reviewCount }} review)
                    </span>
                @else
                    Belum ada rating
                @endif
            </div>

            <!-- NOTIFIKASI -->
            @if (session('success'))
                <div class="alert success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert error">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- FORM TAMBAH REVIEW -->
            @if (session()->has('user_id'))

                <h3>Berikan Review Kamu</h3>

                <form
                    action="{{ route('reviews.store', ['id' => $id]) }}"
                    method="POST"
                >
                    @csrf

                    <div class="form-group">
                        <label for="rating">Rating Film</label>

                        <select name="rating" id="rating" required>
                            <option value="">Pilih rating</option>

                            @for ($i = 10; $i >= 1; $i--)
                                <option
                                    value="{{ $i }}"
                                    {{ old('rating') == $i ? 'selected' : '' }}
                                >
                                    {{ $i }}/10
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="comment">Komentar</label>

                        <textarea
                            name="comment"
                            id="comment"
                            placeholder="Tuliskan pendapat kamu tentang film ini..."
                            required
                            maxlength="2000"
                        >{{ old('comment') }}</textarea>
                    </div>

                    <button type="submit" class="submit-button">
                        Kirim Review
                    </button>
                </form>

            @else

                <p class="info-message">
                    Silakan
                    <a href="{{ route('login') }}" class="login-link">
                        login
                    </a>
                    terlebih dahulu untuk memberikan review film ini.
                </p>

            @endif

            <hr style="border:0;border-top:1px solid #34445a;margin:30px 0;">

            <!-- DAFTAR REVIEW -->
            <h3>Review Pengguna</h3>

            @forelse ($reviews as $review)

                <div class="review-card">

                    <p class="review-user">
                        {{ $review['username'] ?? 'Pengguna' }}
                    </p>

                    <p class="review-rating">
                        ★ {{ $review['rating'] ?? '0' }}/10
                    </p>

                    <p class="review-comment">
                        {{ $review['comment'] ?? '' }}
                    </p>

                    @if (!empty($review['created_at']))
                        <p class="review-date">
                            {{ $review['created_at'] }}
                        </p>
                    @endif

                </div>

            @empty

                <p class="empty-review">
                    Belum ada review untuk film ini. Jadilah yang pertama memberikan review!
                </p>

            @endforelse

        </div>

    </div>

</body>
</html>
