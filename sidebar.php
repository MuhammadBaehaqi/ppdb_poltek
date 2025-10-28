<!-- sidebar.php -->
<div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white bg-dark"
    style="width: 250px; min-height: 100vh; position: fixed;">

    <!-- Logo & Judul -->
    <a href="dashboard.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <img src="img/logo.png" alt="Logo" width="40" class="me-2">
        <span class="fs-5 fw-bold">Admin Panel</span>
    </a>

    <hr>

    <!-- Menu Navigasi -->
    <ul class="nav nav-pills flex-column mb-auto" id="sidebarMenu">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link text-white">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard Admin
            </a>
        </li>

        <li>
            <a href="data_pendaftaran.php" class="nav-link text-white">
                <i class="bi bi-person-lines-fill me-2"></i> Data Pendaftaran
            </a>
        </li>

        <li>
            <a href="data_kontak.php" class="nav-link text-white">
                <i class="bi bi-envelope-fill me-2"></i> Data Kontak
            </a>
        </li>

        <li>
            <a href="kelola_admin.php" class="nav-link text-white">
                <i class="bi bi-person-gear me-2"></i> Kelola Admin
            </a>
        </li>

        <li>
            <a href="kelola_user.php" class="nav-link text-white">
                <i class="bi bi-people-fill me-2"></i> Kelola User
            </a>
        </li>
    </ul>

    <hr>
</div>

<!-- Script agar menu tetap aktif setelah diklik -->
<script>
    const links = document.querySelectorAll('#sidebarMenu .nav-link');

    // Saat diklik, simpan href ke localStorage
    links.forEach(link => {
        link.addEventListener('click', function () {
            localStorage.setItem('activeMenu', this.getAttribute('href'));
        });
    });

    // Saat halaman dimuat ulang, beri class active ke menu yang tersimpan
    const activeMenu = localStorage.getItem('activeMenu');
    if (activeMenu) {
        links.forEach(link => {
            if (link.getAttribute('href') === activeMenu) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }
</script>

<!-- Style efek aktif -->
<style>
    .nav-link.active {
        background-color: #0d6efd !important;
        color: #fff !important;
        border-radius: 8px;
        transition: 0.3s;
    }

    .nav-link:hover {
        background-color: #0b5ed7 !important;
        color: #fff !important;
    }
</style>