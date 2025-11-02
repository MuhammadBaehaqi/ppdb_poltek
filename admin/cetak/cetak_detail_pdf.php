<?php
require('../../includes/koneksi.php');
require_once('../../libs/fpdf186/fpdf.php');

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan!");
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM tb_pendaftaran WHERE id_pendaftaran='$id'");
$data = mysqli_fetch_assoc($query);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'DETAIL PENDAFTARAN MAHASISWA', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 12);
foreach ($data as $key => $value) {
    $pdf->Cell(60, 8, ucfirst(str_replace('_', ' ', $key)), 0);
    $pdf->Cell(0, 8, ': ' . $value, 0, 1);
}

$pdf->Output('I', 'Detail_Pendaftaran.pdf');
?>
