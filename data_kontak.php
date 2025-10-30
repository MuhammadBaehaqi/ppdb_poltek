<?php
session_start();
include 'sidebar_admin.php';
include 'koneksi.php';

// Batasi data per halaman
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // default 10
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Tandai semua pesan belum baca menjadi sudah baca
mysqli_query($conn, "UPDATE kontak SET status_baca = 'sudah baca' WHERE status_baca = 'belum baca'");

// Buat WHERE untuk search
$where = "";
if ($search != '') {
    $where = "WHERE nama LIKE '%$search%' OR email LIKE '%$search%' OR nomor_wa LIKE '%$search%'";
}

// Hitung total data untuk pagination
$total_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM kontak $where");
$total_data = mysqli_fetch_assoc($total_query)['total'];
$total_pages = ceil($total_data / $limit);

// Ambil data kontak sesuai limit dan offset
$query = mysqli_query($conn, "SELECT * FROM kontak $where ORDER BY id_pesan DESC LIMIT $offset, $limit");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kontak | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .main-content { margin-left: 260px; padding: 90px 20px 20px 20px; }
        @media (max-width: 768px) { .main-content { margin-left: 0; padding-top: 100px; } }
        .card { border-radius: 12px; border: none; box-shadow: 0px 2px 10px rgba(0,0,0,0.1); }
        .table th { background-color: #0d6efd; color: #fff; text-align: center; }
        .table td { vertical-align: middle; text-align: center; }
        .pagination .page-link { color: #ff9800; border-color: #ff9800; }
        .pagination .page-item.active .page-link { background-color: #ff9800; border-color: #ff9800; color: white; }
        .pagination .page-link:hover { background-color: #ffe0b2; }
        .btn { border-radius: 8px; }
    </style>
</head>
<body>
<div class="main-content">
    <div class="container-fluid">
        <h3 class="fw-bold mb-4"><i class="bi bi-envelope-fill me-2"></i>Data Kontak</h3>

        <div class="card">
            <div class="card-body">
                <!-- Tombol Show & Search -->
                <div class="d-flex justify-content-between mb-3 align-items-center">
                    <div class="d-flex align-items-center">
                        <form method="GET" id="form-limit" class="d-flex align-items-center">
                            <label class="me-2 mb-0">Tampilkan:</label>
                            <select name="limit" class="form-select form-select-sm" onchange="document.getElementById('form-limit').submit()">
                                <?php
                                $limits = [5,10,15,20,50,100];
                                foreach($limits as $l){
                                    $selected = ($limit == $l) ? 'selected' : '';
                                    echo "<option value='$l' $selected>$l</option>";
                                }
                                ?>
                            </select>
                            <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                        </form>
                    </div>

                    <form method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Cari nama, email, nomor WA..." 
                               value="<?= htmlspecialchars($search) ?>">
                        <input type="hidden" name="limit" value="<?= $limit ?>">
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width:50px;">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Nomor WhatsApp</th>
                                <th>Pesan</th>
                                <th>Tanggal</th>
                                <th style="width:160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = $offset + 1;
                        if(mysqli_num_rows($query) > 0){
                            while($row = mysqli_fetch_assoc($query)){
                                echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['nama']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['nomor_wa']}</td>
                                    <td>{$row['pesan']}</td>
                                    <td>" . date('d-m-Y H:i', strtotime($row['tanggal'])) . "</td>
                                    <td>
                                        <a href='https://wa.me/{$row['nomor_wa']}' target='_blank' class='btn btn-sm btn-success me-1' title='Balas via WhatsApp'><i class='bi bi-whatsapp'></i></a>
                                        <a href='mailto:{$row['email']}' class='btn btn-sm btn-primary me-1' title='Balas via Email'><i class='bi bi-envelope-fill'></i></a>
                                        <a href='hapus_kontak.php?id={$row['id_pesan']}' class='btn btn-sm btn-danger' title='Hapus Pesan' onclick='return confirm(\"Yakin ingin menghapus pesan ini?\")'><i class='bi bi-trash-fill'></i></a>
                                    </td>
                                </tr>";
                                $no++;
                            }
                        }else{
                            echo "<tr><td colspan='7' class='text-center text-muted'>Belum ada pesan masuk</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

                <?php
                // Range data yang ditampilkan
                $start_data = $offset + 1;
                $end_data = min($offset + $limit, $total_data);
                ?>

                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                    <div class="text-muted small mb-2 mb-md-0">
                        Menampilkan <strong><?= $start_data ?></strong>–<strong><?= $end_data ?></strong> dari <strong><?= $total_data ?></strong> data
                    </div>

                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <!-- Previous -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>">Previous</a>
                            </li>

                            <!-- Nomor halaman -->
                            <?php for($i=1;$i<=$total_pages;$i++): ?>
                                <li class="page-item <?= ($page==$i)?'active':'' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next -->
                            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>
