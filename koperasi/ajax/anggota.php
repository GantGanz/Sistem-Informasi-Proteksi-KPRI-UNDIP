<?php
require '../src/functions.php';
$keyword = $_GET["keyword"];
$query = "SELECT * FROM anggota WHERE
        nama LIKE '%$keyword%' OR tempat_lahir LIKE '%$keyword%' OR tanggal_lahir LIKE '%$keyword%' OR 
        fakultas LIKE '%$keyword%' OR rt LIKE '%$keyword%' OR rw LIKE '%$keyword%' OR desa LIKE '%$keyword%' OR kecamatan LIKE '%$keyword%' OR 
        kabupaten LIKE '%$keyword%' OR provinsi LIKE '%$keyword%' OR nip LIKE '%$keyword%' OR no_anggota LIKE '%$keyword%' OR 
        no_hp LIKE '%$keyword%'";
$anggota = query($query);
?>
<table class="table table-striped table-bordered table-sm">
    <thead class="thead-dark">
        <tr>
            <th scope="col" rowspan="2">No</th>
            <th scope="col" rowspan="2">Nama</th>
            <th scope="col" colspan="2">Tempat Tanggal Lahir</th>
            <th scope="col" rowspan="2">Unit Fakultas</th>
            <th scope="col" colspan="6">Alamat Rumah</th>
            <th scope="col" rowspan="2">NIP</th>
            <th scope="col" rowspan="2">No. Anggota</th>
            <th scope="col" rowspan="2">No. HP</th>
            <th scope="col" rowspan="2" colspan="2">Aksi</th>
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
                <th><?= filter_var($i); ?></th>
                <td><?= filter_var($row["nama"]); ?></td>
                <td><?= filter_var($row["tempat_lahir"]); ?></td>
                <td><?= filter_var($row["tanggal_lahir"]); ?></td>
                <td><?= filter_var($row["fakultas"]); ?></td>
                <td><?= filter_var($row["rt"]); ?></td>
                <td><?= filter_var($row["rw"]); ?></td>
                <td><?= filter_var($row["desa"]); ?></td>
                <td><?= filter_var($row["kecamatan"]); ?></td>
                <td><?= filter_var($row["kabupaten"]); ?></td>
                <td><?= filter_var($row["provinsi"]); ?></td>
                <td><?= filter_var($row["nip"]); ?></td>
                <td><?= filter_var($row["no_anggota"]); ?></td>
                <td><?= filter_var($row["no_hp"]); ?></td>
                <td><a href="updateAnggota.php?id=<?= filter_var($row["id"]); ?>"><i class=" fas fa-pencil-alt"></i></a></td>
                <td><a href="dataAnggota.php?id=<?= filter_var($row["id"]); ?>" onclick="return confirm('Apakah anda yakin menghapus data?');"><i class="fas fa-trash-alt"></i></a></td>
            </tr>
            <?php $i++ ?>
        <?php endforeach ?>
    </tbody>
</table>