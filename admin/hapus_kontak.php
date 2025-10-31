<?php
include '../includes/koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($conn, "DELETE FROM kontak WHERE id_pesan = $id");
}

header("Location: data_kontak.php");
exit;
?>
