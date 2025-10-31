<?php
// auth.php — tempatkan di folder yang aman
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah admin login — pakai id dan role untuk lebih aman
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    // pastikan tidak ada output sebelum header() di file lain
    header('Location: /ppdb_poltek/login.php?pesan=belum_login');

    exit();
}

// Opsional: cek timeout session (mis. 30 menit)
$timeout_seconds = 30 * 60;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_seconds) {
    // timeout -> destroy
    session_unset();
    session_destroy();
    header('Location: /ppdb_poltek/login.php?pesan=session_timeout');
    exit();
}
$_SESSION['last_activity'] = time();
