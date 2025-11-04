<?php
// auth_user.php — proteksi halaman untuk mahasiswa/user

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pastikan user sudah login
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'mahasiswa') {
    header('Location: /pmb_poltekmkm/login.php?pesan=belum_login');
    exit();
}

// Opsional: cek timeout session (mis. 30 menit)
$timeout_seconds = 30 * 60;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_seconds) {
    session_unset();
    session_destroy();
    header('Location: /pmb_poltekmkm/login.php?pesan=session_timeout');
    exit();
}

$_SESSION['last_activity'] = time();
?>
