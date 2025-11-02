<?php
include '../../includes/koneksi.php';
if (!isset($_GET['id'])) {
    die("ID tidak ditemukan!");
}

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_pendaftaran WHERE id_pendaftaran='$id'"));

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Detail_Pendaftaran_{$data['nama_lengkap']}.xls");

echo "<table border='1'>";
foreach ($data as $key => $value) {
    echo "<tr><th>" . ucfirst(str_replace('_', ' ', $key)) . "</th><td>$value</td></tr>";
}
echo "</table>";
?>
