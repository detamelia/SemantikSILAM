<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pangkalan Data Mahasiswa') - Portal Akademik</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>
    <div class="app-layout">
        <!-- Sidebar Kiri -->
        <aside class="app-sidebar">
            <!-- Sidebar Header Brand -->
            <div class="sidebar-header">
                <div class="brand-badge">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
                <div>
                    <div class="brand-title">Portal Mahasiswa</div>
                    <div class="brand-subtitle">Pangkalan Data Akademik</div>
                </div>
            </div>

            <!-- Sidebar Navigation Menu -->
            <div class="sidebar-content">
                <div class="menu-category">Menu Utama</div>
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('mahasiswa.index') }}" class="sidebar-item {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span>Data Mahasiswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('prodi.index') }}" class="sidebar-item {{ request()->routeIs('prodi.*') ? 'active' : '' }}">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>Program Studi</span>
                        </a>
                    </li>
                </ul>

                <div class="menu-category">Analisis & Layanan</div>
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ route('statistik.index') }}" class="sidebar-item {{ request()->routeIs('statistik.*') ? 'active' : '' }}">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <span>Statistik</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('panduan') }}" class="sidebar-item {{ request()->routeIs('panduan') ? 'active' : '' }}">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Panduan Sistem</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Sidebar User Info -->
            <div class="sidebar-footer">
                <div class="sidebar-user-avatar">BA</div>
                <div>
                    <div class="sidebar-user-name">Biro Akademik</div>
                    <div class="sidebar-user-role">Administrator Data</div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="app-main">
            <!-- Topbar Header -->
            <header class="topbar">
                <div class="topbar-left">
                    <span class="semester-badge">
                        <span class="dot"></span>
                        Semester Ganjil 2026/2027
                    </span>
                </div>
                <div class="topbar-right">
                    <span style="font-size: 0.82rem; color: var(--gray-text-sub);">
                        Pangkalan Data Terpusat &bull; Aktif
                    </span>
                </div>
            </header>

            <!-- Page Body -->
            <main class="content-wrapper">
                <!-- Flash Message Sukses -->
                @if (session('success'))
                    <div class="alert alert-success">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                <!-- Flash Message Error -->
                @if (session('error'))
                    <div class="alert alert-danger">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                <!-- Global Error List -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <div>
                            <strong>Terjadi kesalahan input:</strong>
                            <ul style="margin-left: 1.25rem; margin-top: 4px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="footer">
                <div class="footer-content">
                    <div>
                        &copy; {{ date('Y') }} <strong>Portal Mahasiswa</strong> &bull; Pangkalan Data Akademik Terpadu
                    </div>
                    <div style="color: var(--gray-text-sub);">
                        Layanan Administrasi Data Mahasiswa
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Global -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <svg width="22" height="22" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                <div class="modal-title">Konfirmasi Penghapusan</div>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data mahasiswa <strong id="deleteTargetNama">-</strong> (<span id="deleteTargetNpm">-</span>)? Tindakan ini tidak dapat dibatalkan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeDeleteModal()">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus Data</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Helper -->
    <script>
        function confirmDelete(url, nama, npm) {
            document.getElementById('deleteForm').action = url;
            document.getElementById('deleteTargetNama').textContent = nama;
            document.getElementById('deleteTargetNpm').textContent = npm;
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('deleteModal');
            if (e.target === modal) {
                closeDeleteModal();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
