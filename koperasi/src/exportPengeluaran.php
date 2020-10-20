<?php
session_start();
if (true != filter_var($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';
$anggota = query("SELECT * FROM anggota");

$pengeluaran = query("SELECT * FROM pengeluaran");

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data_pengeluaran.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
    <table border="1">
        <thead>
            <tr>
                <th scope="col" rowspan="2">No</th>
                <th scope="col" colspan="3">Identitas</th>
                <th scope="col" rowspan="2">Tanggal Cair</th>
                <th scope="col" rowspan="2">Nominal Cair</th>
                <th scope="col" colspan="2">Penerima</th>
            </tr>
            <tr>
                <th scope="col">Nama</th>
                <th scope="col">Fakultas</th>
                <th scope="col">No. Anggota</th>
                <th scope="col">Nama</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($pengeluaran as $row) : ?>
                <tr>
                    <th><?= $i; ?></th>
                    <td><?= $row["nama"]; ?></td>
                    <td><?= $row["fakultas"]; ?></td>
                    <td><?= $row["no_anggota"]; ?></td>
                    <td><?= $row["tgl_cair"]; ?></td>
                    <?php
                    $angka = $row["nominal_cair"];
                    $angka_format = number_format($angka, 2, ",", ".");
                    ?>
                    <td>Rp<?= $angka_format; ?></td>
                    <td><?= $row["nama_penerima"]; ?></td>
                    <td><?= $row["status"]; ?></td>
                </tr>
                <?php $i++ ?>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>