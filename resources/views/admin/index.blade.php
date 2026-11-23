
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Film - MovieVault</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #101827;
            color: #f8fafc;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 245px;
            background: #0b1220;
            padding: 30px 20px;
            position: fixed;
            height: 100vh;
            border-right: 1px solid #263449;
            display: flex;
            flex-direction: column;
        }

        .logo {
            color: #a3e635;
            font-size: 23px;
            font-weight: bold;
            margin-bottom: 45px;
        }

        .menu-title {
            color: #64748b;
            font-size: 14px;
            font-weight: bold;
            margin: 0 10px 18px;
            letter-spacing: 1px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #cbd5e1;
            text-decoration: none;
            padding: 16px 15px;
            border-radius: 10px;
            margin-bottom: 8px;
            font-size: 17px;
            transition: 0.2s;
        }

        .menu a:hover,
        .menu a.active {
            background: #263449;
            color: #a3e635;
        }

        .menu-icon {
            width: 20px;
            text-align: center;
        }

        .sidebar-bottom {
            margin-top: auto;
        }

        .logout-button {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 14px 15px;
            background: transparent;
            border: none;
            color: #f87171;
            font-size: 16px;
            text-align: left;
            cursor: pointer;
            border-radius: 8px;
        }

        .logout-button:hover {
            background: #263449;
        }

        /* MAIN CONTENT */
        .main {
            margin-left: 245px;
            padding: 35px;
            width: calc(100% - 245px);
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .topbar h1 {
            margin: 0 0 8px;
            font-size: 28px;
        }

        .topbar p {
            color: #94a3b8;
            margin: 0;
            font-size: 14px;
        }

        .admin-label {
            background: #263449;
            color: #a3e635;
            padding: 10px 16px;
            border-radius: 20px;
            font-size: 13px;
        }

        /* ALERT */
        .alert {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .success {
            background: #17351f;
            color: #bef264;
        }

        .error {
            background: #451a1a;
            color: #fecaca;
        }

        /* MOVIE SECTION */
        .section {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 25px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .section-header h2 {
            font-size: 21px;
            margin: 0 0 7px;
        }

        .section-header p {
            color: #94a3b8;
            font-size: 13px;
            margin: 0;
        }

        .btn {
            display: inline-block;
            padding: 12px 17px;
            border: none;
            border-radius: 7px;
            background: #a3e635;
            color: #101827;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
            white-space: nowrap;
        }

        .btn:hover {
            background: #bef264;
        }

        /* TABLE */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            text-align: left;
            padding: 16px 12px;
            border-bottom: 1px solid #334155;
            font-size: 13px;
        }

        th {
            color: #94a3b8;
            font-weight: 600;
        }

        td {
            color: #e2e8f0;
        }

        .badge {
            display: inline-block;
            background: #263449;
            color: #a3e635;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
        }

        .delete-btn {
            background: #7f1d1d;
            color: #fecaca;
            border: none;
            padding: 9px 13px;
            border-radius: 6px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background: #991b1b;
        }

        .empty {
            text-align: center;
            padding: 35px;
            color: #94a3b8;
        }

        /* RESPONSIVE */
        @media (max-width: 800px) {
            .sidebar {
                width: 190px;
            }

            .main {
                margin-left: 190px;
                width: calc(100% - 190px);
                padding: 22px;
            }
        }

        @media (max-width: 600px) {
            .layout {
                display: block;
            }

            .sidebar {
                position: static;
                width: 100%;
                height: auto;
            }

            .sidebar-bottom {
                margin-top: 15px;
            }

            .main {
                margin: 0;
                width: 100%;
                padding: 20px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .section-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo">
            MOVIEVAULT.
        </div>

        <div class="menu-title">
            MENU UTAMA
        </div>

        <nav class="menu">

            <a href="{{ route('admin.index') }}" class="active">
                <span class="menu-icon">&#9635;</span>
                Kelola Film
            </a>

            <a href="{{ route('movies.index') }}">
                <span class="menu-icon">&#9671;</span>
                Lihat Website
            </a>

        </nav>

        <div class="sidebar-bottom">

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="logout-button">
                    <span class="menu-icon">&#8617;</span>
                    Logout
                </button>
            </form>

        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main">

        <div class="topbar">

            <div>
                <h1>Kelola Film</h1>
                <p>Kelola koleksi film yang tersedia di MovieVault.</p>
            </div>

            <div class="admin-label">
                Administrator
            </div>

        </div>

        <!-- NOTIFIKASI -->
        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- DAFTAR FILM -->
        <section class="section">

            <div class="section-header">

                <div>
                    <h2>Daftar Film</h2>
                    <p>Daftar seluruh film yang tersimpan di MovieVault.</p>
                </div>

                <a href="{{ route('admin.movies.create') }}" class="btn">
                    + Tambah Film
                </a>

            </div>

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul Film</th>
                            <th>Tahun</th>
                            <th>Genre</th>
                            <th>Rating</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($movies as $index => $movie)

                            @php
                                $genres = $movie['genre'] ?? [];

                                if ($genres instanceof \Traversable) {
                                    $genres = iterator_to_array($genres);
                                }

                                if (!is_array($genres)) {
                                    $genres = [$genres];
                                }

                                $genres = array_map(function ($genre) {
                                    return is_scalar($genre)
                                        ? (string) $genre
                                        : '';
                                }, $genres);

                                $movieId = (string) $movie['_id'];
                            @endphp

                            <tr>

                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <strong>
                                        {{ $movie['title'] ?? 'Tanpa judul' }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $movie['release_year'] ?? '-' }}
                                </td>

                                <td>
                                    {{ implode(', ', $genres) }}
                                </td>

                                <td>
                                    <span class="badge">
                                        {{ $movie['rating'] ?? 0 }}/10
                                    </span>
                                </td>

                                <td>

                                    <form
                                        action="{{ route('admin.movies.destroy', $movieId) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus film ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="delete-btn">
                                            Hapus
                                        </button>
                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="empty">
                                    Belum ada film yang tersedia.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

    </main>

</div>

</body>
</html>
