<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';
$anggota = query("SELECT * FROM mutasi");

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data_mutasi.xls");
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
                <th scope="col">No</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Kode</th>
                <th scope="col">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($anggota as $row) : ?>
                <tr>
                    <th><?= filter_var($i); ?></th>
                    <td><?= filter_var($row["tanggal"]); ?></td>
                    <td><?= filter_var($row["keterangan"]); ?></td>
                    <td><?= filter_var($row["kode"]); ?></td>
                    <?php
                    $angka = $row["jumlah"];
                    $angka_format = number_format($angka, 2, ",", ".");
                    ?>
                    <td>Rp<?= filter_var($angka_format); ?></td>
                </tr>
                <?php $i++ ?>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>