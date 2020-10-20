<?php
session_start();
if (true != filter_var($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';
$pemasukan = query("SELECT * FROM pemasukan");

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data_pemasukkan.xls");
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
                <th scope="col" rowspan="2">Awal Kredit</th>
                <th scope="col" rowspan="2">Akhir Kredit</th>
                <th scope="col" rowspan="2">Nominal Kredit</th>
                <th scope="col" rowspan="2">Persentase</th>
                <th scope="col" rowspan="2">Nominal Proteksi</th>
            </tr>
            <tr>
                <th scope="col">Nama</th>
                <th scope="col">Fakultas</th>
                <th scope="col">No. Anggota</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($pemasukan as $row) : ?>
                <tr>
                    <th><?= $i; ?></th>
                    <td><?= $row["nama"]; ?></td>
                    <td><?= $row["fakultas"]; ?></td>
                    <td><?= $row["no_anggota"]; ?></td>
                    <td><?= $row["awal"]; ?></td>
                    <td><?= $row["akhir"]; ?></td>
                    <?php
                    $angka = $row["nominal"];
                    $angka_format = number_format($angka, 2, ",", ".");
                    $angka2 = $row["nominal_akhir"];
                    $angka_format2 = number_format($angka2, 2, ",", ".");
                    ?>
                    <td>Rp<?= $angka_format; ?></td>
                    <td><?= $row["persentase"]; ?></td>
                    <td>Rp<?= $angka_format2; ?></td>
                </tr>
                <?php $i++ ?>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>