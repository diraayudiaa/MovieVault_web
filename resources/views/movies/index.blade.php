
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies - MovieVault</title>

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

        /* NAVBAR */
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
            font-weight: normal;
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

        .logout-form,
        .add-form {
            margin: 0;
        }

        .logout-button {
            padding: 9px 15px;
            border: none;
            border-radius: 6px;
            background: #ef4444;
            color: white;
            cursor: pointer;
            font-size: 13px;
        }

        .logout-button:hover {
            background: #dc2626;
        }

        /* PAGE HEADER */
        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            margin: 0 0 10px;
            font-size: 30px;
        }

        .subtitle {
            color: #aab4c5;
            line-height: 1.6;
        }

        /* SUCCESS MESSAGE */
        .success-message {
            padding: 14px 18px;
            margin-bottom: 22px;
            border-radius: 8px;
            background: #365314;
            color: #d9f99d;
        }

        /* SEARCH AND FILTER */
        .filter-section {
            margin-bottom: 25px;
        }

        .filter-label {
            display: block;
            margin-bottom: 10px;
            color: #cbd5e1;
            font-size: 14px;
            font-weight: bold;
        }

        .movie-search {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .movie-search select,
        .movie-search input {
            min-height: 50px;
            padding: 13px 16px;
            border: 1px solid #34445a;
            border-radius: 9px;
            outline: none;
            background: #1c293b;
            color: white;
            font-size: 14px;
        }

        .movie-search select {
            min-width: 180px;
            cursor: pointer;
        }

        .movie-search input {
            flex: 1;
            min-width: 220px;
        }

        .movie-search select:focus,
        .movie-search input:focus {
            border-color: #a3e635;
        }

        .movie-search input::placeholder {
            color: #94a3b8;
        }

        .movie-search select option {
            background: #1c293b;
            color: white;
        }

        /* MOVIE GRID */
        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 22px;
        }

        .movie-card {
            position: relative;
            padding: 24px;
            background: #1c293b;
            border: 1px solid #34445a;
            border-radius: 12px;
            transition: transform 0.2s, border-color 0.2s;
        }

        .movie-card:hover {
            transform: translateY(-4px);
            border-color: #a3e635;
        }

        .movie-card h2 {
            margin: 0 0 14px;
            padding-right: 35px;
            color: #a3e635;
            font-size: 21px;
        }

        .genre {
            color: #93c5fd;
            font-size: 14px;
        }

        .rating {
            color: #facc15;
            font-weight: bold;
        }

        .year {
            color: #94a3b8;
            font-size: 14px;
        }

        .description {
            color: #cbd5e1;
            line-height: 1.7;
            font-size: 14px;
        }

        .director {
            color: #e2e8f0;
            font-size: 14px;
        }

        /* WATCHLIST */
        .add-form {
            position: absolute;
            top: 18px;
            right: 18px;
        }

        .add-button {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 50%;
            background: #a3e635;
            color: #101827;
            font-size: 24px;
            cursor: pointer;
        }

        .add-button:hover {
            background: #bef264;
        }

        .watchlist-note {
            display: inline-block;
            margin-bottom: 12px;
            color: #a3e635;
            font-size: 13px;
        }

        .login-note {
            color: #94a3b8;
            font-size: 13px;
            margin-top: 16px;
        }

        /* DETAIL */
        .detail-link {
            display: inline-block;
            margin-top: 12px;
            color: #38bdf8;
            text-decoration: none;
            font-size: 14px;
        }

        .detail-link:hover {
            color: #7dd3fc;
        }

        /* EMPTY */
        .empty {
            color: #fca5a5;
            padding: 20px;
        }

        .no-results {
            display: none;
            grid-column: 1 / -1;
            padding: 35px 20px;
            text-align: center;
            background: #1c293b;
            border: 1px solid #34445a;
            border-radius: 12px;
            color: #94a3b8;
        }

        /* RESPONSIVE */
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

            .page-header h1 {
                font-size: 25px;
            }

            .movie-search {
                flex-direction: column;
            }

            .movie-search select,
            .movie-search input {
                width: 100%;
                min-width: 0;
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

                @if (session('role') === 'admin')
                    <a href="{{ route('admin.index') }}"
                       title="Kembali ke Admin"
                       style="
                           color: #a3e635;
                           font-size: 26px;
                           font-weight: bold;
                           text-decoration: none;
                           margin-right: 20px;
                           display: flex;
                           align-items: center;
                       "
                       onmouseover="this.style.color='white'"
                       onmouseout="this.style.color='#a3e635'">
                        ←
                    </a>
                @endif

                @if (session()->has('user_id'))

                    <a href="{{ route('movies.index') }}" class="active">
                        Movies
                    </a>

                    @if (session('role') !== 'admin')
                        <a href="{{ route('watchlist.index') }}">
                            My Watchlist
                        </a>
                    @endif

                    <a href="{{ route('profile.index') }}">
                        Profile
                    </a>

                    <form action="{{ route('logout') }}"
                          method="POST"
                          class="logout-form">
                        @csrf

                        <button type="submit" class="logout-button">
                            Logout
                        </button>
                    </form>

                @else

                    <a href="{{ route('movies.index') }}" class="active">
                        Movies
                    </a>

                    <a href="{{ route('login') }}">
                        Login
                    </a>

                    <a href="{{ route('register') }}">
                        Register
                    </a>

                @endif

            </div>
        </nav>

        <!-- PAGE HEADER -->
        <div class="page-header">
            <h1>MovieVault Movies</h1>

            <p class="subtitle">
                Jelajahi berbagai film favorit dari database MongoDB.
            </p>
        </div>

        <!-- SUCCESS MESSAGE -->
        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <!-- SEARCH AND FILTER -->
        <div class="filter-section">

            <label class="filter-label" for="searchFilter">
                Cari dan Filter Film
            </label>

            <div class="movie-search">

                <select id="searchFilter">
                    <option value="all">Semua Filter</option>
                    <option value="title">Judul Film</option>
                    <option value="genre">Genre</option>
                    <option value="year">Tahun Rilis</option>
                </select>

                <select id="filterValue" style="display: none;">
                    <option value="">Pilih pilihan...</option>
                </select>

                <input
                    type="search"
                    id="movieSearch"
                    placeholder="Cari judul, genre, atau tahun film..."
                    autocomplete="off"
                >

            </div>
        </div>

        <!-- MOVIE LIST -->
        <div class="movie-grid" id="movieGrid">

            @forelse ($movies as $movie)

                @php

                    $toPlainArray = function ($value) {

                        if (
                            $value instanceof \MongoDB\Model\BSONArray ||
                            $value instanceof \MongoDB\Model\BSONDocument
                        ) {
                            return $value->getArrayCopy();
                        }

                        if ($value instanceof \Traversable) {
                            return iterator_to_array($value);
                        }

                        return $value;
                    };

                    $toDisplayText = function (
                        $value,
                        $fallback = '-'
                    ) use ($toPlainArray) {

                        $value = $toPlainArray($value);

                        if (is_array($value)) {

                            $items = [];

                            foreach ($value as $item) {

                                $item = $toPlainArray($item);

                                if (is_scalar($item)) {
                                    $items[] = trim((string) $item);
                                }
                            }

                            $value = implode(
                                ', ',
                                array_filter($items)
                            );
                        }

                        if (!is_scalar($value)) {
                            return $fallback;
                        }

                        $value = trim((string) $value);

                        return $value !== '' ? $value : $fallback;
                    };

                    $movieId = (string) $movie['_id'];

                    $title = $toDisplayText(
                        $movie['title'] ?? null,
                        'Tanpa Judul'
                    );

                    $genres = $toDisplayText(
                        $movie['genres'] ?? $movie['genre'] ?? null,
                        'Genre tidak tersedia'
                    );

                    $rating = $toDisplayText(
                        $movie['average_review_rating'] ?? null,
                        '0.0'
                    );

                    $reviewCount = (int) ($movie['review_count'] ?? 0);

                    $year = $toDisplayText(
                        $movie['release_year'] ?? $movie['year'] ?? null,
                        '-'
                    );

                    $description = $toDisplayText(
                        $movie['description'] ?? null,
                        'Tidak ada deskripsi.'
                    );

                    $director = $toDisplayText(
                        $movie['director'] ?? null,
                        '-'
                    );

                    $isInWatchlist = in_array(
                        $movieId,
                        $watchlistMovieIds ?? [],
                        true
                    );

                @endphp

                <div
                    class="movie-card"
                    data-title="{{ mb_strtolower($title) }}"
                    data-genre="{{ mb_strtolower($genres) }}"
                    data-year="{{ mb_strtolower($year) }}"
                    data-search="{{ mb_strtolower($title . ' ' . $genres . ' ' . $year) }}"
                >

                    <!-- WATCHLIST BUTTON -->
                    @if (session()->has('user_id') && session('role') !== 'admin')

                        @if (!$isInWatchlist)

                            <form
                                action="{{ route('watchlist.store', $movieId) }}"
                                method="POST"
                                class="add-form"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="add-button"
                                    title="Tambah ke Watchlist"
                                >
                                    +
                                </button>
                            </form>

                        @else

                            <span class="watchlist-note">
                                ✓ Sudah di Watchlist
                            </span>

                        @endif

                    @endif

                    <!-- MOVIE INFORMATION -->
                    <h2>{{ $title }}</h2>

                    <p class="genre">
                        {{ $genres }}
                    </p>

                    <p class="rating">
                        @if ($reviewCount > 0)
                            ★ {{ $rating }}/10
                            <span style="color:#94a3b8;font-size:12px;font-weight:normal;">
                                ({{ $reviewCount }} review)
                            </span>
                        @else
                            Belum ada rating
                        @endif
                    </p>

                    <p class="year">
                        Tahun rilis: {{ $year }}
                    </p>

                    <p class="description">
                        {{ $description }}
                    </p>

                    <p class="director">
                        <strong>Director:</strong>
                        {{ $director }}
                    </p>

                    <a
                        href="{{ route('movies.show', $movieId) }}"
                        class="detail-link"
                    >
                        Lihat Detail Film →
                    </a>

                    @if (!session()->has('user_id'))
                        <p class="login-note">
                            Login untuk menambahkan film ke Watchlist.
                        </p>
                    @endif

                </div>

            @empty

                <p class="empty">
                    Data film belum tersedia.
                </p>

            @endforelse

            <!-- NO RESULTS -->
            <div class="no-results" id="noResults">
                <h3>Film tidak ditemukan</h3>
                <p>
                    Coba pilih filter atau kata kunci yang berbeda.
                </p>
            </div>

        </div>

    </div>

    <!-- SEARCH JAVASCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const searchFilter = document.getElementById('searchFilter');
            const filterValue = document.getElementById('filterValue');
            const searchInput = document.getElementById('movieSearch');
            const movieCards = document.querySelectorAll('.movie-card');
            const noResults = document.getElementById('noResults');

            function getOptions(type) {

                const values = new Set();

                movieCards.forEach(function (card) {

                    if (type === 'genre') {

                        const genres = (card.dataset.genre || '')
                            .split(',')
                            .map(item => item.trim())
                            .filter(item => item && item !== 'genre tidak tersedia');

                        genres.forEach(genre => values.add(genre));

                    }

                    if (type === 'year') {

                        const year = (card.dataset.year || '').trim();

                        if (year && year !== '-') {
                            values.add(year);
                        }

                    }

                });

                return Array.from(values).sort(function (a, b) {

                    if (type === 'year') {
                        return Number(b) - Number(a);
                    }

                    return a.localeCompare(b);
                });
            }

            function updateFilterOptions() {

                const type = searchFilter.value;

                filterValue.innerHTML =
                    '<option value="">Pilih pilihan...</option>';

                searchInput.value = '';

                if (type === 'genre' || type === 'year') {

                    filterValue.style.display = 'block';
                    searchInput.style.display = 'none';

                    const options = getOptions(type);

                    options.forEach(function (value) {

                        const option = document.createElement('option');

                        option.value = value.toLowerCase();
                        option.textContent = value;

                        filterValue.appendChild(option);

                    });

                } else {

                    filterValue.style.display = 'none';
                    searchInput.style.display = 'block';

                    if (type === 'title') {
                        searchInput.placeholder = 'Cari judul film...';
                    } else {
                        searchInput.placeholder =
                            'Cari judul, genre, atau tahun film...';
                    }

                }

                searchMovies();
            }

            function searchMovies() {

                const type = searchFilter.value;
                const keyword = searchInput.value.toLowerCase().trim();
                const selectedValue = filterValue.value;

                let visibleCount = 0;

                movieCards.forEach(function (card) {

                    let matched = false;

                    if (type === 'all') {

                        const data = card.dataset.search || '';
                        matched = data.includes(keyword);

                    } else if (type === 'title') {

                        const title = card.dataset.title || '';
                        matched = title.includes(keyword);

                    } else if (type === 'genre') {

                        const genres = (card.dataset.genre || '')
                            .split(',')
                            .map(item => item.trim());

                        matched = selectedValue !== '' &&
                            genres.includes(selectedValue);

                    } else if (type === 'year') {

                        const year = card.dataset.year || '';

                        matched = selectedValue !== '' &&
                            year.trim() === selectedValue;

                    }

                    card.style.display = matched ? '' : 'none';

                    if (matched) {
                        visibleCount++;
                    }

                });

                noResults.style.display =
                    movieCards.length > 0 && visibleCount === 0
                        ? 'block'
                        : 'none';
            }

            searchFilter.addEventListener(
                'change',
                updateFilterOptions
            );

            filterValue.addEventListener(
                'change',
                searchMovies
            );

            searchInput.addEventListener(
                'input',
                searchMovies
            );

            updateFilterOptions();

        });
    </script>

</body>
</html>
