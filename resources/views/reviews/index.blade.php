
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - MovieVault</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 35px 20px;
            font-family: Arial, sans-serif;
            background: #101827;
            color: white;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
            padding: 18px 24px;
            margin-bottom: 35px;
            background: #1c293b;
            border: 1px solid #34445a;
            border-radius: 12px;
        }

        .navbar-brand-wrapper {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .navbar-brand {
            color: #a3e635;
            font-size: 23px;
            font-weight: bold;
            text-decoration: none;
        }

        .username {
            color: #a3e635;
            font-size: 13px;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .navbar-links a {
            color: #cbd5e1;
            text-decoration: none;
            font-size: 14px;
        }

        .navbar-links a:hover,
        .navbar-links a.active {
            color: #a3e635;
        }

        .logout-form {
            margin: 0;
        }

        .logout-button {
            padding: 9px 15px;
            border: none;
            border-radius: 6px;
            background: #ef4444;
            color: white;
            cursor: pointer;
        }

        .page-header {
            margin-bottom: 28px;
        }

        h1 {
            margin: 0 0 10px;
            font-size: 30px;
        }

        .subtitle {
            color: #aab4c5;
            line-height: 1.6;
        }

        .review-form {
            background: #1c293b;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid #34445a;
            border-radius: 12px;
        }

        .review-form h2 {
            margin: 0 0 10px;
            color: #a3e635;
            font-size: 21px;
        }

        .form-description {
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 22px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 9px;
            font-size: 14px;
            font-weight: bold;
        }

        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            background: #101827;
            border: 1px solid #475569;
            border-radius: 7px;
            color: white;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #a3e635;
        }

        .rating-help {
            color: #94a3b8;
            font-size: 12px;
            margin-top: 7px;
        }

        .submit-button {
            padding: 12px 22px;
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
            padding: 14px 18px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 14px;
        }

        .success {
            background: #365314;
            color: #d9f99d;
        }

        .error {
            background: #7f1d1d;
            color: #fecaca;
        }

        .review-section-title {
            margin-bottom: 18px;
            font-size: 22px;
        }

        .review-card {
            background: #1c293b;
            padding: 22px;
            margin-bottom: 18px;
            border-radius: 12px;
            border: 1px solid #34445a;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 12px;
        }

        .review-username {
            font-weight: bold;
            color: #a3e635;
        }

        .rating {
            color: #facc15;
            font-weight: bold;
        }

        .comment {
            color: #e2e8f0;
            line-height: 1.7;
            margin: 0;
        }

        .date {
            margin-top: 15px;
            font-size: 12px;
            color: #94a3b8;
        }

        .empty {
            background: #1c293b;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #34445a;
            color: #fca5a5;
        }

        .login-note {
            padding: 18px;
            background: #1c293b;
            border: 1px solid #34445a;
            border-radius: 10px;
            color: #cbd5e1;
            margin-bottom: 30px;
        }

        .login-note a {
            color: #a3e635;
        }

        @media (max-width: 650px) {
            body {
                padding: 20px 12px;
            }

            .navbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .navbar-links {
                gap: 14px;
            }

            h1 {
                font-size: 25px;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="navbar-brand-wrapper">
            <a href="{{ route('movies.index') }}" class="navbar-brand">
                MovieVault
            </a>

            @if (session()->has('user_id'))
                <span class="username">
                    Halo, {{ session('username') }}!
                </span>
            @endif
        </div>

        <div class="navbar-links">
            @if (session()->has('user_id'))
                <a href="{{ route('movies.index') }}">Movies</a>
                <a href="{{ route('reviews.index') }}" class="active">Reviews</a>
                <a href="{{ route('watchlist.index') }}">My Watchlist</a>
                <a href="{{ route('profile.index') }}">Profile</a>

                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-button">Logout</button>
                </form>
            @else
                <a href="{{ route('movies.index') }}">Movies</a>
                <a href="{{ route('reviews.index') }}" class="active">Reviews</a>
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endif
        </div>
    </nav>

    <!-- HEADER -->
    <div class="page-header">
        <h1>MovieVault Reviews</h1>
        <p class="subtitle">
            Bagikan pendapat dan penilaianmu tentang film.
        </p>
    </div>

    <!-- NOTIFICATION -->
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
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- ADD REVIEW FORM -->
    @if (session()->has('user_id'))
        <div class="review-form">

            <h2>+ Tulis Review</h2>

            <p class="form-description">
                Berikan rating dan tuliskan pendapatmu tentang film.
            </p>

            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="rating">Rating Film</label>

                    <select name="rating" id="rating" required>
                        <option value="">Pilih rating</option>

                        @foreach (range(10, 1) as $number)
                            <option
                                value="{{ $number }}"
                                {{ old('rating') == $number ? 'selected' : '' }}
                            >
                                {{ $number }}/10
                            </option>
                        @endforeach
                    </select>

                    <p class="rating-help">
                        1 = Sangat buruk, 10 = Sangat bagus.
                    </p>
                </div>

                <div class="form-group">
                    <label for="comment">Komentar</label>

                    <textarea
                        name="comment"
                        id="comment"
                        placeholder="Ceritakan pendapatmu tentang film..."
                        maxlength="2000"
                        required
                    >{{ old('comment') }}</textarea>
                </div>

                <button type="submit" class="submit-button">
                    Kirim Review
                </button>
            </form>
        </div>
    @else
        <div class="login-note">
            Silakan <a href="{{ route('login') }}">login</a>
            terlebih dahulu untuk menambahkan review.
        </div>
    @endif

    <!-- REVIEW LIST -->
    <h2 class="review-section-title">Semua Review</h2>

    @forelse ($reviews as $review)
        <div class="review-card">

            <div class="review-header">
                <span class="review-username">
                    {{ $review['username'] ?? 'Anonymous' }}
                </span>

                <span class="rating">
                    ★ {{ $review['rating'] ?? 0 }}/10
                </span>
            </div>

            <p class="comment">
                {{ $review['comment'] ?? 'Tidak ada komentar.' }}
            </p>

            <div class="date">
                {{ $review['created_at'] ?? '-' }}
            </div>

        </div>
    @empty
        <div class="empty">
            Belum ada review yang tersedia.
        </div>
    @endforelse

</div>
</body>
</html>
