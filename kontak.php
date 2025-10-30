<?php
include 'navbar.php';
include 'koneksi.php'; // koneksi ke database

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nomor_wa = mysqli_real_escape_string($conn, $_POST['nomor_wa']);
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);

    $query = "INSERT INTO kontak (nama, email, nomor_wa, pesan) VALUES ('$nama', '$email', '$nomor_wa', '$pesan')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pesan berhasil dikirim!'); window.location.href='kontak.php';</script>";
    } else {
        echo "<script>alert('Gagal mengirim pesan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Kami | Politeknik Mitra Karya Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<!-- Hero Section -->
<section class="position-relative text-white text-center" style="height: 60vh;">
    <img src="img/kontak.jpg" class="w-100 h-100 position-absolute top-0 start-0" style="object-fit: cover;" alt="Kontak MKM">
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"></div>
    <div class="position-relative d-flex flex-column justify-content-center align-items-center h-100">
        <h1 class="fw-bold">Hubungi Kami</h1>
        <p class="lead">Kami siap membantu menjawab pertanyaan dan kebutuhan informasi Anda</p>
    </div>
</section>

<!-- Info Kontak -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col">
                <h2 class="text-warning mb-3">Informasi Kontak</h2>
                <p>Silakan hubungi kami melalui salah satu kontak di bawah ini atau kirim pesan melalui formulir.</p>
            </div>
        </div>

        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <div class="mb-3 text-warning fs-3">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h5 class="fw-bold">Alamat</h5>
                    <p>Jl. Raya Ketanggungan No. 45, Brebes, Jawa Tengah</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <div class="mb-3 text-warning fs-3">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <h5 class="fw-bold">Telepon</h5>
                    <p>(0283) 123456 / +62 812-3456-7890</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <div class="mb-3 text-warning fs-3">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <h5 class="fw-bold">Email</h5>
                    <p>info@politeknikmkm.ac.id</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Formulir Kontak -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="text-warning mb-3">Kirim Pesan</h2>
            <p>Isi formulir berikut untuk mengirimkan pertanyaan atau permintaan informasi kepada kami.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="" method="post" class="card border-0 shadow p-4">
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama Anda" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email Anda" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_wa" class="form-label fw-semibold">Nomor WhatsApp</label>
                        <input type="text" id="nomor_wa" name="nomor_wa" class="form-control" placeholder="Contoh: 6281234567890" required>
                    </div>
                    <div class="mb-3">
                        <label for="pesan" class="form-label fw-semibold">Pesan</label>
                        <textarea id="pesan" name="pesan" rows="5" class="form-control" placeholder="Tulis pesan Anda di sini..." required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-warning px-5">Kirim Pesan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Lokasi Kampus -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="text-warning mb-4">Lokasi Kampus</h2>
        <div class="ratio ratio-16x9 rounded shadow">
            <iframe 
                src="https://www.google.com/maps?q=Politeknik%20Mitra%20Karya%20Mandiri%20Ketanggungan%20Brebes&output=embed" 
                style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
