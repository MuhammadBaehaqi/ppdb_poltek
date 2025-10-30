<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

// Validasi koneksi
if (!isset($conn) || !$conn) {
    header("Location: login.php?pesan=gagal&reason=db_connection");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

$username = trim($_POST['username']);
$password = $_POST['password'];

// Validasi input kosong
if ($username === '' || $password === '') {
    header("Location: login.php?pesan=gagal&reason=empty");
    exit();
}

/* -----------------------------------------------------------
   1️⃣ Coba cek dulu di tabel admin
----------------------------------------------------------- */
$stmt = mysqli_prepare($conn, "SELECT id, nama_admin, username, email, password, role FROM admin WHERE username = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) === 1) {
    mysqli_stmt_bind_result($stmt, $id, $nama_admin, $db_username, $email, $db_password, $role);
    mysqli_stmt_fetch($stmt);

    if (password_verify($password, $db_password)) {
        $_SESSION['admin_id'] = $id;
        $_SESSION['nama_admin'] = $nama_admin;
        $_SESSION['username'] = $db_username;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;

        header("Location: dashboard_admin.php");
        exit();
    } else {
        header("Location: login.php?pesan=gagal&reason=password_mismatch");
        exit();
    }
}

/* -----------------------------------------------------------
   2️⃣ Jika tidak ditemukan di tabel admin, cek di tb_user
----------------------------------------------------------- */
$stmt2 = mysqli_prepare($conn, "SELECT id_user, nama_lengkap, username, password, role, status_akun 
                               FROM tb_user WHERE username = ? LIMIT 1");
mysqli_stmt_bind_param($stmt2, "s", $username);
mysqli_stmt_execute($stmt2);
mysqli_stmt_store_result($stmt2);

if (mysqli_stmt_num_rows($stmt2) === 1) {
    mysqli_stmt_bind_result($stmt2, $id_user, $nama_lengkap, $db_username, $db_password, $role, $status_akun);
    mysqli_stmt_fetch($stmt2);

    if (!password_verify($password, $db_password)) {
        header("Location: login.php?pesan=gagal&reason=password_mismatch");
        exit();
    }

    if ($status_akun !== 'aktif') {
        echo "<script>alert('Akun Anda belum aktif. Tunggu verifikasi admin.');window.location='login.php';</script>";
        exit();
    }

    // Login mahasiswa sukses
    $_SESSION['id_user'] = $id_user;
    $_SESSION['nama_lengkap'] = $nama_lengkap;
    $_SESSION['username'] = $db_username;
    $_SESSION['role'] = $role;

    header("Location: user/dashboard_user.php");
    exit();
}

/* -----------------------------------------------------------
   3️⃣ Kalau dua-duanya tidak ditemukan
----------------------------------------------------------- */
header("Location: login.php?pesan=gagal&reason=user_not_found");
exit();
?>
