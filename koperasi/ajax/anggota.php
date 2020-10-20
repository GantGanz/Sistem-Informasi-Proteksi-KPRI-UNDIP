<?php
require '../src/functions.php';
$keyword = filter_input(INPUT_GET, 'keyword');
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
                <td><a href="updateAnggota.php?id=<?= $row["id"]; ?>"><i class=" fas fa-pencil-alt"></i></a></td>
                <td><a href="dataAnggota.php?id=<?= $row["id"]; ?>" onclick="return confirm('Apakah anda yakin menghapus data?');"><i class="fas fa-trash-alt"></i></a></td>
            </tr>
            <?php $i++ ?>
        <?php endforeach ?>
    </tbody>
</table>