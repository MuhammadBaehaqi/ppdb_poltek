<?php

include '../includes/koneksi.php';

// Hitung total data
$jumlah_pendaftaran_pending = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM tb_pendaftaran WHERE status_pendaftaran = 'Pending'"
))['total'];

$jumlah_pesan_baru = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM kontak WHERE status_baca = 'belum baca'"
))['total'];


// kalau user sudah klik menu kontak, sembunyikan sementara
if (isset($_SESSION['kontak_diklik']) && $_SESSION['kontak_diklik'] === true) {
    $jumlah_pesan_baru = 0;
}

// total gabungan
$total_notif = $jumlah_pendaftaran_pending + $jumlah_pesan_baru;
?>


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
                <img src="../img/logo_mkm.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>Admin</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="../logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<!-- Sidebar -->
<?php
$current_page = basename($_SERVER['PHP_SELF']); 

// Gabungkan beberapa halaman ke satu kategori
if (in_array($current_page, ['pendaftaran_tambah.php', 'pendaftaran_edit.php'])) {
    $current_page = 'data_pendaftaran.php';
}
?>

<div class="sidebar bg-dark text-white p-3" id="sidebar">
    <a href="dashboard_admin.php" class="d-flex align-items-center mb-3 text-white text-decoration-none">
        <img src="../img/logo_mkm.png" alt="Logo" width="40" class="me-2">
        <span class="fs-5 fw-bold">Admin Panel</span>
    </a>
    <hr>

    <ul class="nav nav-pills flex-column mb-auto" id="sidebarMenu">
        <!-- Dashboard -->
        <li>
            <a href="dashboard_admin.php"
                class="nav-link text-white d-flex justify-content-between align-items-center <?= ($current_page == 'dashboard_admin.php') ? 'active' : ''; ?>">
                <span><i class="bi bi-speedometer2 me-2"></i> Dashboard</span>
                <?php if (!empty($total_notif) && $total_notif > 0): ?>
                    <span class="badge bg-danger"><?= $total_notif; ?></span>
                <?php endif; ?>
            </a>
        </li>

        <!-- Data Pendaftaran -->
        <li>
            <a href="data_pendaftaran.php"
                class="nav-link text-white d-flex justify-content-between align-items-center <?= ($current_page == 'data_pendaftaran.php') ? 'active' : ''; ?>">
                <span><i class="bi bi-person-lines-fill me-2"></i> Data Pendaftaran</span>
                <?php if (!empty($jumlah_pendaftaran_pending) && $jumlah_pendaftaran_pending > 0): ?>
                    <span class="badge bg-warning text-dark"><?= $jumlah_pendaftaran_pending; ?></span>
                <?php endif; ?>
            </a>
        </li>

        <!-- Data Kontak -->
        <li>
            <a href="data_kontak.php"
                class="nav-link text-white d-flex justify-content-between align-items-center <?= ($current_page == 'data_kontak.php') ? 'active' : ''; ?>">
                <span><i class="bi bi-envelope-fill me-2"></i> Data Kontak</span>
                <?php if (!empty($jumlah_pesan_baru) && $jumlah_pesan_baru > 0): ?>
                    <span class="badge bg-success"><?= $jumlah_pesan_baru; ?></span>
                <?php endif; ?>
            </a>
        </li>

        <!-- Kelola Admin -->
        <li>
            <a href="kelola_admin.php"
                class="nav-link text-white <?= ($current_page == 'kelola_admin.php') ? 'active' : ''; ?>">
                <i class="bi bi-person-gear me-2"></i> Kelola Admin
            </a>
        </li>

        <!-- Kelola User -->
        <li>
            <a href="kelola_user.php"
                class="nav-link text-white <?= ($current_page == 'kelola_user.php') ? 'active' : ''; ?>">
                <i class="bi bi-people-fill me-2"></i> Kelola User
            </a>
        </li>
            <?php
            $current_page = basename($_SERVER['PHP_SELF']);
            $laporan_pages = ['laporan_perbulan.php', 'laporan_perminggu.php', 'laporan_pertahun.php'];
            $isLaporanActive = in_array($current_page, $laporan_pages);
            ?>

            <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center text-white <?= $isLaporanActive ? 'active' : 'collapsed'; ?>" 
                data-bs-toggle="collapse" href="#laporanMenu" role="button" aria-expanded="<?= $isLaporanActive ? 'true' : 'false'; ?>" 
                aria-controls="laporanMenu">
                <span><i class="bi bi-bar-chart me-2"></i> Laporan</span>
                <i class="bi <?= $isLaporanActive ? 'bi-chevron-down' : 'bi-chevron-right'; ?>"></i>
            </a>

            <div class="collapse <?= $isLaporanActive ? 'show' : ''; ?>" id="laporanMenu">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ms-4">
                    <li>
                    <a href="laporan_perminggu.php"
                    class="nav-link text-white <?= $current_page == 'laporan_perminggu.php' ? 'active' : ''; ?>">
                    🗓️ Per Minggu
                    </a>
                </li>
                <li>
                    <a href="laporan_perbulan.php"
                    class="nav-link text-white <?= $current_page == 'laporan_perbulan.php' ? 'active' : ''; ?>">
                    🗓️ Per Bulan
                    </a>
                </li>
                <li>
                    <a href="laporan_pertahun.php"
                    class="nav-link text-white <?= $current_page == 'laporan_pertahun.php' ? 'active' : ''; ?>">
                    📆 Per Tahun
                    </a>
                </li>
                </ul>
            </div>
            </li>
        <style>
            /* Parent menu aktif (misalnya Laporan saat di halaman laporan mana pun) */
            .nav-link.active {
            background-color: #0d6efd !important;
            color: #fff !important;
            font-weight: 600;
            border-radius: 6px;
            }

            /* Submenu aktif */
            #laporanMenu .nav-link.active {
            background-color: #0b5ed7 !important;
            color: #fff !important;
            }

            /* Hover efek */
            #laporanMenu .nav-link:hover {
            background-color: #0b5ed7 !important;
            color: #fff !important;
            }

            /* Warna aktif hanya untuk item yang sedang dipilih */
            #laporanMenu .nav-link.active {
                background-color: #0d6efd !important;
                color: #fff !important;
                border-radius: 6px;
                font-weight: 600;
            }

            /* Saat hover */
            #laporanMenu .nav-link:hover {
                background-color: #0b5ed7 !important;
                color: #fff !important;
            }
        </style>
    </ul>
</div>

<!-- Sidebar Script -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const mainContent = document.body;

        if (toggleBtn) {
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
        }
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');
    const mainContent = document.body;

    // Sidebar toggle
    if (toggleBtn) {
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
    }

    // --- 🔽 Tambahan: panah laporan otomatis berubah arah ---
    const laporanToggle = document.querySelector('[href="#laporanMenu"]');
    const laporanIcons = laporanToggle.querySelectorAll('i.bi');
    const laporanArrow = laporanIcons[laporanIcons.length - 1]; // ambil ikon panah terakhir
    const laporanMenu = document.getElementById('laporanMenu');

    laporanMenu.addEventListener('show.bs.collapse', () => {
        laporanArrow.classList.remove('bi-chevron-right');
        laporanArrow.classList.add('bi-chevron-down');
    });

    laporanMenu.addEventListener('hide.bs.collapse', () => {
        laporanArrow.classList.remove('bi-chevron-down');
        laporanArrow.classList.add('bi-chevron-right');
    });
});
</script>


<!-- Style -->
<style>
    /* Blur background */
    .blur-active::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(6px);
        background: rgba(0, 0, 0, 0.2);
        z-index: 1030;
        transition: all 0.3s ease;
    }

    /* Sidebar base */
    .sidebar {
        z-index: 1040;
        width: 250px;
        min-height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 70px;
        transition: all 0.3s ease;
    }

    /* Responsive sidebar */
    @media (max-width: 991.98px) {
        .sidebar {
            left: -250px;
            background-color: rgba(33, 37, 41, 0.98);
        }

        .sidebar.active {
            left: 0;
        }
    }

    /* Navbar offset */
    @media (min-width: 992px) {
        .navbar {
            margin-left: 250px;
            width: calc(100% - 250px);
            transition: all 0.3s ease;
        }
    }

    /* Link styles */
    .nav-link {
        transition: background-color 0.2s ease;
        border-radius: 8px;
    }

    .nav-link.active {
        background-color: #0d6efd !important;
        color: #fff !important;
        font-weight: 600;
    }

    .nav-link:hover {
        background-color: #0b5ed7 !important;
        color: #fff !important;
    }

    #laporanMenu .nav-link {
        padding-left: 1.5rem;
    }

    #laporanMenu .nav-link.active {
        background-color: #0b5ed7 !important;
    }
</style>