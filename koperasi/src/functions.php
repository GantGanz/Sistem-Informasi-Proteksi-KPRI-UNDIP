<?php
$conn = mysqli_connect("localhost", "root", "", "koperasi");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data)
{
    global $conn;

    $nama = htmlspecialchars($data["nama"]);
    $tempat_lahir = htmlspecialchars($data["tempat_lahir"]);
    $tanggal_lahir = htmlspecialchars($data["tanggal_lahir"]);
    $fakultas = htmlspecialchars($data["fakultas"]);
    $rt = htmlspecialchars($data["rt"]);
    $rw = htmlspecialchars($data["rw"]);
    $desa = htmlspecialchars($data["desa"]);
    $kecamatan = htmlspecialchars($data["kecamatan"]);
    $kabupaten = htmlspecialchars($data["kabupaten"]);
    $provinsi = htmlspecialchars($data["provinsi"]);
    $nip = htmlspecialchars($data["nip"]);
    $no_anggota = htmlspecialchars($data["no_anggota"]);
    $no_hp = htmlspecialchars($data["no_hp"]);

    $query = "INSERT INTO anggota VALUES 
            ('', '$nama',  '$fakultas', '$nip', '$tempat_lahir', '$tanggal_lahir', '$rt', '$rw', '$desa', '$kecamatan', '$kabupaten', 
            '$provinsi', '$no_anggota', '$no_hp')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM anggota WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function update($data)
{
    global $conn;

    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $tempat_lahir = htmlspecialchars($data["tempat_lahir"]);
    $tanggal_lahir = htmlspecialchars($data["tanggal_lahir"]);
    $fakultas = htmlspecialchars($data["fakultas"]);
    $rt = htmlspecialchars($data["rt"]);
    $rw = htmlspecialchars($data["rw"]);
    $desa = htmlspecialchars($data["desa"]);
    $kecamatan = htmlspecialchars($data["kecamatan"]);
    $kabupaten = htmlspecialchars($data["kabupaten"]);
    $provinsi = htmlspecialchars($data["provinsi"]);
    $nip = htmlspecialchars($data["nip"]);
    $no_anggota = htmlspecialchars($data["no_anggota"]);
    $no_hp = htmlspecialchars($data["no_hp"]);

    $query = "UPDATE anggota SET 
                nama = '$nama', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', 
                fakultas = '$fakultas', rt = '$rt', rw = '$rw', desa = '$desa', kecamatan = '$kecamatan', 
                kabupaten = '$kabupaten', provinsi = '$provinsi', nip = '$nip', no_anggota = '$no_anggota', 
                no_hp = '$no_hp' 
            WHERE id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cari($keyword)
{
    $query = "SELECT * FROM anggota WHERE
                nama LIKE '%$keyword%' OR tempat_lahir LIKE '%$keyword%' OR tanggal_lahir LIKE '%$keyword%' OR 
                fakultas LIKE '%$keyword%' OR rt LIKE '%$keyword%' OR rw LIKE '%$keyword%' OR desa LIKE '%$keyword%' OR kecamatan LIKE '%$keyword%' OR 
                kabupaten LIKE '%$keyword%' OR provinsi LIKE '%$keyword%' OR nip LIKE '%$keyword%' OR no_anggota LIKE '%$keyword%' OR 
                no_hp LIKE '%$keyword%'";
    return query($query);
}

function tambahFakultas($data)
{
    global $conn;
    $nama = htmlspecialchars($data["fakultas"]);
    $query = "INSERT INTO fakultas VALUES ('', '$nama')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapusFakultas($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM fakultas WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function updateFakultas($data)
{
    global $conn;
    $id = $data["id"];
    $nama = htmlspecialchars($data["updateFakultas"]);
    $query = "UPDATE fakultas SET nama = '$nama' WHERE id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapusAlumni($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM alumni WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function cariAlumni($keyword)
{
    $query = "SELECT * FROM alumni WHERE
                nama LIKE '%$keyword%' OR tempat_lahir LIKE '%$keyword%' OR tanggal_lahir LIKE '%$keyword%' OR 
                fakultas LIKE '%$keyword%' OR rt LIKE '%$keyword%' OR rw LIKE '%$keyword%' OR desa LIKE '%$keyword%' OR kecamatan LIKE '%$keyword%' OR 
                kabupaten LIKE '%$keyword%' OR provinsi LIKE '%$keyword%' OR nip LIKE '%$keyword%' OR no_anggota LIKE '%$keyword%' OR 
                no_hp LIKE '%$keyword%'";
    return query($query);
}

function cariPersentase($keyword)
{
    $query = "SELECT * FROM persentase WHERE
                tahun LIKE '%$keyword%' OR persentase LIKE '%$keyword%' OR min LIKE '%$keyword%' OR 
                max LIKE '%$keyword%'";
    return query($query);
}

function cariPersentaseTahun($keyword)
{
    $query = "SELECT * FROM persentase WHERE tahun LIKE '%$keyword%' ORDER BY tahun ASC";
    return query($query);
}

function cariPersentaseAkhir()
{
    $query = "SELECT * FROM persentase ORDER BY tahun ASC";
    return query($query);
}

function cariPersentaseMin($keyword)
{
    $query = "SELECT * FROM persentase WHERE min LIKE '%$keyword%'";
    return query($query);
}

function cariPersentaseMax($keyword)
{
    $query = "SELECT * FROM persentase WHERE max LIKE '%$keyword%'";
    return query($query);
}

function hapusPersentase($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM persentase WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function tambahPersentase($data)
{
    global $conn;

    $tahun = htmlspecialchars($data["tahun"]);
    $persentase = htmlspecialchars($data["persentase"]);
    $min = htmlspecialchars($data["min"]);
    $max = htmlspecialchars($data["max"]);

    $query = "INSERT INTO persentase VALUES 
            ('', '$tahun', '$persentase', '$min', '$max')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function updatePersentase($data)
{
    global $conn;

    $id = $data["id"];
    $tahun = htmlspecialchars($data["tahun"]);
    $persentase = htmlspecialchars($data["persentase"]);
    $min = htmlspecialchars($data["min"]);
    $max = htmlspecialchars($data["max"]);

    $query = "UPDATE persentase SET 
                tahun = '$tahun', persentase = '$persentase', min = '$min', max = '$max'
            WHERE id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cariPemasukan($keyword)
{
    $query = "SELECT * FROM pemasukan WHERE nama LIKE '%$keyword%' OR fakultas LIKE '%$keyword%' OR no_anggota LIKE '%$keyword%' OR awal LIKE '%$keyword%' OR nominal LIKE '%$keyword%' OR persentase LIKE '%$keyword%' OR nominal_akhir LIKE '%$keyword%' OR akhir LIKE '%$keyword%'";
    return query($query);
}

function hapusPemasukan($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM pemasukan WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function tambahPemasukan($data)
{
    global $conn;

    $id = htmlspecialchars($data["id"]);
    $daftar_anggota = query("SELECT * FROM anggota WHERE id = $id");

    $nama = htmlspecialchars($daftar_anggota[0]["nama"]);
    $fakultas = htmlspecialchars($daftar_anggota[0]["fakultas"]);
    $no_anggota = htmlspecialchars($daftar_anggota[0]["no_anggota"]);
    $awal = htmlspecialchars($data["awal"]);
    $nominal = htmlspecialchars($data["nominal"]);
    $akhir = htmlspecialchars($data["akhir"]);

    $tahun = substr($awal, 0, 4);
    $kemungkinan = cariPersentaseTahun($tahun);
    $kemungkinan2 = cariPersentaseAkhir();
    $ada = false;
    $persentase = 0;
    foreach ($kemungkinan as $row) {
        if ($nominal >= filter_var($row["min"]) && filter_var($row["max"]) >= $nominal) {
            $persentase = filter_var($row["persentase"]);
        } else if ($row["max"] <= $nominal) {
            $persentase = filter_var($row["persentase"]);
        }
    }
    if ($ada == false) {
        foreach ($kemungkinan2 as $row) {
            if ($nominal >= filter_var($row["min"]) && $row["max"] >= $nominal) {
                $persentase = filter_var($row["persentase"]);
            } else if (filter_var($row["max"]) <= $nominal) {
                $persentase = filter_var($row["persentase"]);
            }
        }
    }
    $nominal_akhir = $nominal * $persentase / 100;

    $query = "INSERT INTO pemasukan VALUES 
            ('', '$nama', '$fakultas', '$no_anggota','$nominal', '$nominal_akhir', '$awal', '$akhir', '$persentase')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function updatePemasukkan($data)
{
    global $conn;

    $id = htmlspecialchars($data["id"]);
    $daftar_anggota = query("SELECT * FROM anggota WHERE id = $id");

    $idp = $data["idp"];
    $nama = htmlspecialchars($daftar_anggota[0]["nama"]);
    $fakultas = htmlspecialchars($daftar_anggota[0]["fakultas"]);
    $no_anggota = htmlspecialchars($daftar_anggota[0]["no_anggota"]);
    $awal = htmlspecialchars($data["awal"]);
    $nominal = htmlspecialchars($data["nominal"]);
    $akhir = htmlspecialchars($data["akhir"]);

    $tahun = substr($awal, 0, 4);
    $kemungkinan = cariPersentaseTahun($tahun);
    $kemungkinan2 = cariPersentaseAkhir();
    $ada = false;
    foreach ($kemungkinan as $row) {
        if ($nominal >= filter_var($row["min"]) && filter_var($row["max"]) >= $nominal) {
            $persentase = filter_var($row["persentase"]);
            $ada = true;
        }
    }
    if ($ada == false) {
        foreach ($kemungkinan2 as $row) {
            if ($nominal >= filter_var($row["min"]) && filter_var($row["max"]) >= $nominal) {
                $persentase = filter_var($row["persentase"]);
            }
        }
    }
    $nominal_akhir = $nominal * $persentase / 100;

    $query = "UPDATE pemasukan SET 
                nama = '$nama', fakultas = '$fakultas', no_anggota = '$no_anggota', awal = '$awal', nominal = '$nominal', persentase = '$persentase', nominal_akhir = '$nominal_akhir', akhir = '$akhir'
            WHERE id = $idp";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cariPengeluaran($keyword)
{
    $query = "SELECT * FROM pengeluaran WHERE nama LIKE '%$keyword%' OR fakultas LIKE '%$keyword%' OR no_anggota LIKE '%$keyword%' OR tgl_cair LIKE '%$keyword%' OR nominal_cair LIKE '%$keyword%' OR nama_penerima LIKE '%$keyword%' OR status LIKE '%$keyword%'";
    return query($query);
}

function hapusPengeluaran($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM pengeluaran WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function tambahPengeluaran($data)
{
    global $conn;

    $id = htmlspecialchars($data["id"]);
    $daftar_anggota = query("SELECT * FROM anggota WHERE id = $id");

    $nama = htmlspecialchars($daftar_anggota[0]["nama"]);
    $fakultas = htmlspecialchars($daftar_anggota[0]["fakultas"]);
    $no_anggota = htmlspecialchars($daftar_anggota[0]["no_anggota"]);
    $tgl_cair = htmlspecialchars($data["tgl_cair"]);
    $nominal_cair = htmlspecialchars($data["nominal_cair"]);
    $nama_penerima = htmlspecialchars($data["nama_penerima"]);
    $status = htmlspecialchars($data["status"]);

    $query = "INSERT INTO pengeluaran VALUES 
            ('', '$nama', '$fakultas', '$no_anggota', '$tgl_cair', '$nama_penerima', '$status',  '$nominal_cair')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function updatePengeluaran($data)
{
    global $conn;

    $id = $data["id"];
    $ida = htmlspecialchars($data["ida"]);
    $daftar_anggota = query("SELECT * FROM anggota WHERE id = $ida");

    $nama = htmlspecialchars($daftar_anggota[0]["nama"]);
    $fakultas = htmlspecialchars($daftar_anggota[0]["fakultas"]);
    $no_anggota = htmlspecialchars($daftar_anggota[0]["no_anggota"]);
    $tgl_cair = htmlspecialchars($data["tgl_cair"]);
    $nominal_cair = htmlspecialchars($data["nominal_cair"]);
    $nama_penerima = htmlspecialchars($data["nama_penerima"]);
    $status = htmlspecialchars($data["status"]);

    $query = "UPDATE pengeluaran SET 
                nama = '$nama', fakultas = '$fakultas', no_anggota = '$no_anggota', tgl_cair = '$tgl_cair',  nominal_cair = '$nominal_cair', nama_penerima = '$nama_penerima', status = '$status'
                WHERE id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cariMutasi($keyword)
{
    $query = "SELECT * FROM mutasi WHERE
                tanggal LIKE '%$keyword%' OR keterangan LIKE '%$keyword%' OR kode LIKE '%$keyword%' OR jumlah LIKE '%$keyword%'";
    return query($query);
}

function hapusMutasi($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM mutasi WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function tambahMutasi($data)
{
    global $conn;

    $tanggal = htmlspecialchars($data["tanggal"]);
    $keterangan = htmlspecialchars($data["keterangan"]);
    $kode = htmlspecialchars($data["kode"]);
    $jumlah = htmlspecialchars($data["jumlah"]);

    $query = "INSERT INTO mutasi VALUES 
            ('', '$tanggal', '$keterangan', '$jumlah', '$kode')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function updateMutasi($data)
{
    global $conn;

    $id = $data["id"];
    $tanggal = htmlspecialchars($data["tanggal"]);
    $keterangan = htmlspecialchars($data["keterangan"]);
    $kode = htmlspecialchars($data["kode"]);
    $jumlah = htmlspecialchars($data["jumlah"]);

    $query = "UPDATE mutasi SET 
                tanggal = '$tanggal', keterangan = '$keterangan', kode = '$kode', jumlah = '$jumlah'
            WHERE id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
