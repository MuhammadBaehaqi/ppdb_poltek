<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Navbar Atas -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top px-4">
    <div class="container-fluid">
        <!-- Tombol toggle sidebar (mobile) -->
        <button class="btn btn-outline-dark d-lg-none me-2" id="toggleSidebar">
            <i class="bi bi-list fs-4"></i>
        </button>

        <?php
        // Judul halaman otomatis
        $page_titles = [
            'dashboard_user' => 'Dashboard Mahasiswa',
            'pengaturan' => 'Pengaturan Akun'
        ];
        $page_title = $page_titles[basename($_SERVER['PHP_SELF'], '.php')] ?? 'Dashboard Mahasiswa';
        ?>

        <h5 class="fw-bold mb-0"><?= htmlspecialchars($page_title) ?></h5>

        <div class="dropdown ms-auto">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../img/logo_mkm.png" alt="User" width="32" height="32" class="rounded-circle me-2">
                <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="../logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar bg-dark text-white p-3" id="sidebar">
    <a href="dashboard_user.php" class="d-flex align-items-center mb-3 text-white text-decoration-none">
        <img src="../img/logo_mkm.png" alt="Logo" width="40" class="me-2">
        <span class="fs-5 fw-bold">Mahasiswa</span>
    </a>
    <hr>

    <ul class="nav nav-pills flex-column mb-auto">
        <li>
            <a href="dashboard_user.php"
                class="nav-link text-white <?= ($current_page == 'dashboard_user.php') ? 'active' : ''; ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="pengaturan.php"
                class="nav-link text-white <?= ($current_page == 'pengaturan.php') ? 'active' : ''; ?>">
                <i class="bi bi-gear-fill me-2"></i> Pengaturan
            </a>
        </li>
        <li>
            <a href="../logout.php" class="nav-link text-white">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </li>
    </ul>
</div>

<!-- Script Toggle -->
<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');
    const mainContent = document.body;

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        mainContent.classList.toggle('blur-active');
    });

    document.addEventListener('click', (e) => {
        if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
            sidebar.classList.remove('active');
            mainContent.classList.remove('blur-active');
        }
    });
</script>

<!-- Style -->
<style>
    /* Efek blur overlay saat sidebar aktif */
    .blur-active::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(6px);
        background: rgba(0, 0, 0, 0.25);
        z-index: 1030;
        transition: all 0.3s ease;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        min-height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 70px;
        transition: all 0.3s ease;
        z-index: 1040;
    }

    .nav-link.active {
        background-color: #0d6efd !important;
        border-radius: 8px;
    }

    .nav-link:hover {
        background-color: #0b5ed7 !important;
        color: #fff !important;
    }

    /* Navbar desktop */
    @media (min-width: 992px) {
        .navbar {
            margin-left: 250px;
            width: calc(100% - 250px);
            transition: all 0.3s ease;
        }
    }

    /* Sidebar overlay (mobile) */
    @media (max-width: 991.98px) {
        .navbar {
            margin-left: 0;
            width: 100%;
        }

        .sidebar {
            left: -250px;
            background-color: rgba(33, 37, 41, 0.98);
        }

        .sidebar.active {
            left: 0;
        }
    }
</style>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>