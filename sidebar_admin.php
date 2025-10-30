<!-- Navbar Atas -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top px-4">
    <div class="container-fluid">
        <!-- Tombol toggle sidebar (hanya muncul di mobile) -->
        <button class="btn btn-outline-dark d-lg-none me-2" id="toggleSidebar">
            <i class="bi bi-list fs-4"></i>
        </button>

        <?php
        // Ambil nama file yang sedang dibuka, misal "data_pendaftaran.php"
        $current_page = basename($_SERVER['PHP_SELF'], ".php");

        // Buat mapping nama file ke judul yang lebih rapi
        $page_titles = [
            'dashboard_admin' => 'Dashboard Admin',
            'data_pendaftaran' => 'Data Pendaftaran',
            'kelola_galeri' => 'Kelola Galeri',
            'kelola_pengasuh' => 'Kelola Pengasuh',
            'kelola_tentang_kami' => 'Kelola Tentang Kami',
            'kelola_kontak' => 'Kelola Kontak',
        ];

        // Ambil judul berdasarkan halaman yang sedang aktif
        $page_title = $page_titles[$current_page] ?? ucfirst(str_replace('_', ' ', $current_page));
        ?>

        <h5 class="fw-bold mb-0"><?= htmlspecialchars($page_title) ?></h5>

        <div class="dropdown ms-auto">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="img/logo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>Admin</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</nav>


<!-- Sidebar -->
<?php
$current_page = basename($_SERVER['PHP_SELF']); // nama file yang sedang dibuka
?>
<div class="sidebar bg-dark text-white p-3" id="sidebar">
    <a href="dashboard_admin.php" class="d-flex align-items-center mb-3 text-white text-decoration-none">
        <img src="img/logo.png" alt="Logo" width="40" class="me-2">
        <span class="fs-5 fw-bold">Admin Panel</span>
    </a>
    <hr>

    <ul class="nav nav-pills flex-column mb-auto" id="sidebarMenu">
        <li>
            <a href="dashboard_admin.php"
                class="nav-link text-white <?php echo ($current_page == 'dashboard_admin.php') ? 'active' : ''; ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard Admin
            </a>
        </li>
        <li>
            <a href="data_pendaftaran.php"
                class="nav-link text-white <?php echo ($current_page == 'data_pendaftaran.php') ? 'active' : ''; ?>">
                <i class="bi bi-person-lines-fill me-2"></i> Data Pendaftaran
            </a>
        </li>
        <li>
            <a href="data_kontak.php"
                class="nav-link text-white <?php echo ($current_page == 'data_kontak.php') ? 'active' : ''; ?>">
                <i class="bi bi-envelope-fill me-2"></i> Data Kontak
            </a>
        </li>
        <li>
            <a href="kelola_admin.php"
                class="nav-link text-white <?php echo ($current_page == 'kelola_admin.php') ? 'active' : ''; ?>">
                <i class="bi bi-person-gear me-2"></i> Kelola Admin
            </a>
        </li>
        <li>
            <a href="kelola_user.php"
                class="nav-link text-white <?php echo ($current_page == 'kelola_user.php') ? 'active' : ''; ?>">
                <i class="bi bi-people-fill me-2"></i> Kelola User
            </a>
        </li>
    </ul>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');
    const mainContent = document.body; // biar seluruh konten di-blur

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        mainContent.classList.toggle('blur-active');
    });

    // Tutup sidebar kalau area luar diklik
    document.addEventListener('click', (e) => {
        if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
            sidebar.classList.remove('active');
            mainContent.classList.remove('blur-active');
        }
    });
</script>


<!-- Style -->
<style>
    /* Efek blur di area konten saat sidebar aktif */
    .blur-active::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(6px);
        background: rgba(0, 0, 0, 0.2);
        /* sedikit gelap */
        z-index: 1030;
        /* di bawah sidebar */
        transition: all 0.3s ease;
    }

    /* Pastikan sidebar tetap di atas blur */
    .sidebar {
        z-index: 1040;
    }

    /* Navbar biar ga ketimpa sidebar saat layar lebar */
    @media (min-width: 992px) {
        .navbar {
            margin-left: 250px;
            /* sesuai lebar sidebar kamu */
            width: calc(100% - 250px);
            transition: all 0.3s ease;
        }
    }

    /* Saat layar kecil (sidebar jadi overlay) */
    @media (max-width: 991px) {
        .navbar {
            margin-left: 0;
            width: 100%;
        }
    }

    .sidebar {
        width: 250px;
        min-height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 70px;
        /* biar gak ketutup navbar */
        transition: all 0.3s ease;
        z-index: 1040;
    }

    /* Sidebar overlay (mobile mode) */
    @media (max-width: 991.98px) {
        .sidebar {
            left: -250px;
            background-color: rgba(33, 37, 41, 0.98);
        }

        .sidebar.active {
            left: 0;
        }
    }

    .nav-link.active {
        background-color: #0d6efd !important;
        border-radius: 8px;
    }

    .nav-link:hover {
        background-color: #0b5ed7 !important;
        color: #fff !important;
    }
</style>