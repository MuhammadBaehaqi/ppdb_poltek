<?php
// cek_login.php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php'; // pastikan file ini ada dan mendefinisikan $conn

// Pastikan koneksi
if (!isset($conn) || !$conn) {
    // Jaga-jaga jika koneksi gagal
    header("Location: login.php?pesan=gagal&reason=db_connection");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validasi sederhana
if ($username === '' || $password === '') {
    header("Location: login.php?pesan=gagal&reason=empty");
    exit();
}

// Prepared statement untuk keamanan
$stmt = mysqli_prepare($conn, "SELECT id, nama_admin, username, email, password, role FROM admin WHERE username = ? LIMIT 1");
if (!$stmt) {
    header("Location: login.php?pesan=gagal&reason=prepare_failed");
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);

// Gunakan store_result + bind_result untuk kompatibilitas
mysqli_stmt_store_result($stmt);
$num = mysqli_stmt_num_rows($stmt);

if ($num === 1) {
    mysqli_stmt_bind_result($stmt, $id, $nama_admin, $db_username, $email, $db_password, $role);
    mysqli_stmt_fetch($stmt);

    // Pastikan string password dari DB ada
    if ($db_password === null || $db_password === '') {
        header("Location: login.php?pesan=gagal&reason=no_password");
        exit();
    }

    // Cek hashed password
    if (password_verify($password, $db_password)) {
        // Login sukses — set session
        $_SESSION['admin_id'] = $id;
        $_SESSION['nama_admin'] = $nama_admin;
        $_SESSION['username'] = $db_username;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;

        // Redirect aman
        header("Location: dashboard_admin.php");
        exit();
    } else {
        // Password mismatch
        header("Location: login.php?pesan=gagal&reason=password_mismatch");
        exit();
    }
} else {
    // Username tidak ditemukan
    header("Location: login.php?pesan=gagal&reason=user_not_found");
    exit();
}
