<?php
require 'functions.php';
$anggota = query("SELECT * FROM anggota");

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data_anggota.xls");
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
            <!-- <tr>
                <td colspan="14" style="text-align:center; height:40px; font-size:20px; font-weight:bold;">Hasil Export</td>
            </tr> -->
            <tr style="height: 30px; vertical-align:middle; text-align:center; font-size: 12px;">
                <th scope="col" rowspan="2">No</th>
                <th scope="col" rowspan="2">Nama</th>
                <th scope="col" colspan="2">Tempat Tanggal Lahir</th>
                <th scope="col" rowspan="2">Unit Fakultas</th>
                <th scope="col" colspan="6">Alamat Rumah</th>
                <th scope="col" rowspan="2">NIP</th>
                <th scope="col" rowspan="2">No. Anggota</th>
                <th scope="col" rowspan="2">No. HP</th>
            </tr>
            <tr>
                <th scope="col">Tempat</th>
                <th scope="col">Tanggal</th>
                <th scope="col">RT</th>
                <th scope="col">RW</th>
                <th scope="col">Desa</th>
                <th scope="col">Kecamatan</th>
                <th scope="col">Kabupaten</th>
                <th scope="col">Provinsi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($anggota as $row) : ?>
                <tr>
                    <th><?= $i; ?></th>
                    <td><?= $row["nama"]; ?></td>
                    <td><?= $row["tempat_lahir"]; ?></td>
                    <td><?= $row["tanggal_lahir"]; ?></td>
                    <td><?= $row["fakultas"]; ?></td>
                    <td><?= $row["rt"]; ?></td>
                    <td><?= $row["rw"]; ?></td>
                    <td><?= $row["desa"]; ?></td>
                    <td><?= $row["kecamatan"]; ?></td>
                    <td><?= $row["kabupaten"]; ?></td>
                    <td><?= $row["provinsi"]; ?></td>
                    <td><?= $row["nip"]; ?></td>
                    <td><?= $row["no_anggota"]; ?></td>
                    <td><?= $row["no_hp"]; ?></td>
                </tr>
                <?php $i++ ?>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>