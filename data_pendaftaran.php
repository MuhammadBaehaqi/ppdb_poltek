<?php 
include 'sidebar_admin.php'; 
include 'koneksi.php'; // koneksi ke database
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendaftaran | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .content {
            margin-left: 260px;
            padding: 90px 20px 20px 20px;
        }
        @media (max-width: 768px) {
            .content {
                margin-left: 0;
                padding-top: 100px;
            }
        }
        .card {
            border: none;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }
        .table th {
            background-color: #0d6efd;
            color: #fff;
            text-align: center;
        }
        .table td {
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="container-fluid">
            <h3 class="fw-bold mb-4"><i class="bi bi-person-lines-fill me-2"></i>Data Pendaftaran Mahasiswa</h3>

            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <button class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Tambah Data</button>
                        </div>
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control" placeholder="Cari nama mahasiswa...">
                            <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>NIK</th>
                                    <th>NISN</th>
                                    <th>Asal SLTA</th>
                                    <th>Program Studi</th>
                                    <th>Rencana Kelas</th>
                                    <th>Bukti Pembayaran</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $query = mysqli_query($conn, "SELECT * FROM tb_pendaftaran ORDER BY id_pendaftaran DESC");
                                if (mysqli_num_rows($query) > 0) {
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $badgeClass = 'bg-warning text-dark';
                                        if ($row['status_pendaftaran'] == 'Diterima') $badgeClass = 'bg-success';
                                        if ($row['status_pendaftaran'] == 'Tidak Diterima') $badgeClass = 'bg-danger';
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                                    <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                                    <td><?= htmlspecialchars($row['alamat']); ?></td>
                                    <td><?= htmlspecialchars($row['nik']); ?></td>
                                    <td><?= htmlspecialchars($row['nisn']); ?></td>
                                    <td><?= htmlspecialchars($row['asal_slta']); ?></td>
                                    <td><?= htmlspecialchars($row['program_studi']); ?></td>
                                    <td><?= htmlspecialchars($row['rencana_kelas']); ?></td>
                                    <td>
                                        <?php if (!empty($row['bukti_pembayaran'])) { ?>
                                            <a href="uploads/<?= $row['bukti_pembayaran']; ?>" target="_blank" class="btn btn-sm btn-info text-white">
                                                <i class="bi bi-eye"></i> Lihat
                                            </a>
                                        <?php } else { ?>
                                            <span class="text-muted">Tidak ada</span>
                                        <?php } ?>
                                    </td>
                                    <td><?= date('d-m-Y', strtotime($row['tanggal_daftar'])); ?></td>
                                    <td><span class="badge <?= $badgeClass; ?>"><?= $row['status_pendaftaran']; ?></span></td>
                                    <td>
                                        <form action="registrasi/update_status.php" method="POST" class="d-inline">
                                            <input type="hidden" name="id_pendaftaran" value="<?= $row['id_pendaftaran']; ?>">
                                            <select name="status" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                                                <option value="Pending" <?= ($row['status_pendaftaran']=='Pending')?'selected':''; ?>>Pending</option>
                                                <option value="Diterima" <?= ($row['status_pendaftaran']=='Diterima')?'selected':''; ?>>Diterima</option>
                                                <option value="Tidak Diterima" <?= ($row['status_pendaftaran']=='Tidak Diterima')?'selected':''; ?>>Tidak Diterima</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='13' class='text-center text-muted'>Belum ada data pendaftaran.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
