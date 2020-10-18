<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

// $pemasukan = query("SELECT * FROM pemasukan WHERE akhir < NOW()");
$pemasukan = query("SELECT * FROM pemasukan");
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data_hangus.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!doctype html>
<html lang="en">

<head>
</head>

<body>
    <table border="1">
        <thead>
            <tr>
                <th scope="col" rowspan="2">No</th>
                <th scope="col" colspan="3">Identitas</th>
                <th scope="col" rowspan="2">Nominal Proteksi</th>
            </tr>
            <tr>
                <th scope="col">Nama</th>
                <th scope="col">Fakultas</th>
                <th scope="col">No. Anggota</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            $total = 0;
            $angka_format = '0,00'; ?>
            <?php foreach ($pemasukan as $row) : ?>
                <?php if (filter_var($row["akhir"]) < date("Y-m-d")) { ?>
                    <tr>
                        <th><?= filter_var($i); ?></th>
                        <td><?= filter_var($row["nama"]); ?></td>
                        <td><?= filter_var($row["fakultas"]); ?></td>
                        <td><?= filter_var($row["no_anggota"]); ?></td>
                        <?php
                        $angka2 = filter_var($row["nominal_akhir"]);
                        $total = $total + filter_var($row["nominal_akhir"]);
                        $angka_format2 = number_format($angka2, 2, ",", ".");
                        $angka_format = number_format($total, 2, ",", ".");
                        ?>
                        <td>Rp<?= $angka_format2; ?></td>
                    </tr>
                    <?php $i++ ?>
                <?php } ?>
            <?php endforeach ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <th>Total : </th>
                <th>Rp<?= $angka_format; ?></th>
            </tr>
        </tbody>
    </table>
    </div>
</body>

</html>