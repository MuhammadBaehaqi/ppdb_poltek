<?php
include '../includes/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap   = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $email          = mysqli_real_escape_string($conn, $_POST['email']);
    $nomor_wa       = mysqli_real_escape_string($conn, $_POST['nomor_wa']);

    // 🔹 Validasi format nomor WhatsApp (boleh +62 atau 0, tapi angka semua)
    if (!preg_match('/^(\+?62\d{8,15}|0\d{8,15})$/', $nomor_wa)) {
        echo "<script>alert('Nomor WhatsApp tidak valid! Gunakan format 081234567890 atau +6281234567890'); history.back();</script>";
        exit;
    }
        // 🔹 Normalisasi nomor ke format +62... agar seragam di database
    $nomor_wa = preg_replace('/[^0-9]/', '', $nomor_wa); // hanya ambil angka

    if (substr($nomor_wa, 0, 1) === '0') {
        $nomor_wa = '+62' . substr($nomor_wa, 1);
    } elseif (substr($nomor_wa, 0, 2) === '62') {
        $nomor_wa = '+' . $nomor_wa;
    } elseif (substr($nomor_wa, 0, 3) !== '+62') {
        // jika belum ada tanda + dan tidak diawali 0, tambahkan +62 sebagai fallback
        $nomor_wa = '+62' . $nomor_wa;
    }

    $jenis_kelamin  = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $alamat         = mysqli_real_escape_string($conn, $_POST['alamat']);
    $nik            = mysqli_real_escape_string($conn, $_POST['nik']);
    // Validasi NIK (harus 16 digit angka)
    if (!preg_match('/^[0-9]{16}$/', $nik)) {
        echo "<script>alert('NIK harus terdiri dari 16 digit angka!'); history.back();</script>";
        exit;
    }
    $nisn           = mysqli_real_escape_string($conn, $_POST['nisn']);
    // Validasi NISN (harus 10 digit angka)
    if (!preg_match('/^[0-9]{10}$/', $nisn)) {
        echo "<script>alert('NISN harus terdiri dari 10 digit angka!'); history.back();</script>";
        exit;
    }
    $asal_slta      = mysqli_real_escape_string($conn, $_POST['asal_slta']);
    $program_studi  = mysqli_real_escape_string($conn, $_POST['program_studi']);
    $rencana_kelas  = mysqli_real_escape_string($conn, $_POST['rencana_kelas']);

    // Upload bukti pembayaran
    $target_dir = "../uploads/";
    $file_name = time() . "_" . basename($_FILES["bukti_pembayaran"]["name"]);
    $target_file = $target_dir . $file_name;

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file);

    // Cek apakah NIK sudah terdaftar
    $cekNik = mysqli_query($conn, "SELECT nik FROM tb_pendaftaran WHERE nik = '$nik'");
    if (mysqli_num_rows($cekNik) > 0) {
        echo "<script>alert('NIK ini sudah terdaftar! Gunakan NIK lain atau hubungi admin.');window.history.back();</script>";
        exit;
    }

    // Cek apakah email sudah terdaftar
    $cekEmail = mysqli_query($conn, "SELECT email FROM tb_pendaftaran WHERE email = '$email'");
    if (mysqli_num_rows($cekEmail) > 0) {
        echo "<script>alert('Email ini sudah digunakan! Gunakan email lain atau hubungi admin.');window.history.back();</script>";
        exit;
    }

    // 🔹 Simpan ke tabel pendaftaran
    $sql1 = "INSERT INTO tb_pendaftaran 
        (nama_lengkap, email, nomor_wa, jenis_kelamin, alamat, nik, nisn, asal_slta, program_studi, rencana_kelas, bukti_pembayaran, status_pendaftaran, tanggal_daftar)
        VALUES 
        ('$nama_lengkap', '$email', '$nomor_wa', '$jenis_kelamin', '$alamat', '$nik', '$nisn', '$asal_slta', '$program_studi', '$rencana_kelas', '$file_name', 'Pending', NOW())";

    if (mysqli_query($conn, $sql1)) {

        // Buat akun otomatis untuk login (username = NIK, password = hash(NIK))
        $password_hashed = password_hash($nik, PASSWORD_DEFAULT);

        // Cek apakah sudah ada di tb_user
        $cekUser = mysqli_query($conn, "SELECT username FROM tb_user WHERE username = '$nik'");
        if (mysqli_num_rows($cekUser) == 0) {
            $sql2 = "INSERT INTO tb_user (nama_lengkap, username, password, role, status_akun, tanggal_daftar)
                     VALUES ('$nama_lengkap', '$nik', '$password_hashed', 'mahasiswa', 'nonaktif', NOW())";
            mysqli_query($conn, $sql2);
        }

        echo "<script>alert('Pendaftaran berhasil! Akun Anda telah dibuat. Tunggu verifikasi admin.');window.location='../index.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menyimpan data.');window.history.back();</script>";
    }
}
?>
