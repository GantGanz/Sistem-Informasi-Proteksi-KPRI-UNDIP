<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}
require 'functions.php';

$daftar_anggota = query("SELECT * FROM anggota ORDER BY nama");
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <link rel="stylesheet" href="../css/formPersentase.css">
  <script src="https://kit.fontawesome.com/8306e7b683.js" crossorigin="anonymous"></script>

  <title>Form Pengeluaran</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container">
      <a class="navbar-brand text-white-50" href="index.php"><i class="fas fa-home">Dashboard</i></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="#">Selamat Datang, <?= filter_input(INPUT_SESSION, 'username'); ?><span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link ml-3" href="dataAnggota.php"><i class="fas fa-users"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link ml-1" href="pemasukkan.php"><i class="fas fa-hand-holding-usd"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link ml-1" href="pengeluaran.php"><i class="fas fa-money-bill-wave"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link ml-1" href="mutasi.php"><i class="fas fa-dna"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link ml-1" href="posisi.php"><i class="fas fa-file-invoice-dollar"></i></a>
          </li>
          <?php if (isset($_SESSION["sadmin"])) { ?>
            <li class="nav-item">
              <a class="nav-link ml-1" href="fakultas.php"><i class="fas fa-hotel"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link ml-1" href="persentase.php"><i class="fas fa-percentage"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link ml-1" href="alumni.php"><i class="fas fa-user-times"></i></a>
            </li>
          <?php } ?>
        </ul>
      </div>
      <a href="logout.php" class="btn btn-danger navbar-right"><i class="fas fa-sign-out-alt"> Keluar</i></a>
    </div>
  </nav>

  <?php
  if (isset($_POST["submit"])) {
    if (tambahPengeluaran($_POST) > 0) { ?>
      <div class="alert alert-success" role="alert">
        Data berhasil ditambahkan, <a href="pengeluaran.php" class="alert-link">Klik disini untuk melihat tabel</a>.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times</span>
        </button>
      </div>
    <?php
    } else { ?>
      <div class="alert alert-warning" role="alert">
        Data gagal ditambahkan <a href="pengeluaran.php" class="alert-link">Klik disini untuk melihat tabel</a>.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times</span>
        </button>
      </div>
  <?php
    }
  }
  ?>

  <div class="container formcontainer border border-dark">
    <h2 class="alert alert-primary text-center mt-3 font-weight-bold">Form Pengeluaran</h2>
    <a href="pengeluaran.php" class="kembali btn btn-secondary ml-2 printInv"><i class="fas fa-arrow-circle-left"> Kembali</i></a>
    <form action="" method="POST" class="font-weight-bold">
      <div class="form-group">
        <label for="id">Identitas (Nama, Fakultas; No. Anggota) : </label>
        <select id="id" class="form-control" name="id">
          <?php foreach ($daftar_anggota as $row) : ?>
            <option value="<?= filter_var($row["id"]); ?>"><?= filter_var($row["nama"]); ?> ; <?= filter_var($row["fakultas"]); ?> ; <?= filter_var($row["no_anggota"]); ?></option>
          <?php endforeach ?>
        </select>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="tgl_cair">Tanggal Cair : </label>
            <input id="tgl_cair" type="date" name="tgl_cair" class="form-control" required autocomplete="off">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="nominal_cair">Nominal Cair : </label>
            <input id="nominal_cair" type="number" name="nominal_cair" class="form-control" required autocomplete="off" placeholder="Masukkan nominal disini, (tanpa titik)">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="nama_penerima">Nama Penerima : </label>
            <input id="nama_penerima" type="text" name="nama_penerima" class="form-control" required autocomplete="off" placeholder="Masukkan nama penerima disini..">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="status">Status Penerima : </label>
            <select id="status" class="form-control" name="status">
              <option value="Anak">Anak</option>
              <option value="Ayah">Ayah/Ibu</option>
              <option value="Ibu">Saudara</option>
              <option value="Lain-Lain">Lain-Lain</option>
            </select>
          </div>
        </div>
      </div>
      <button type="reset" class="btn btn-danger mt-2"><i class="fas fa-trash"> RESET</i></button>
      <button type="submit" name="submit" class="btn btn-primary mt-2 float-right"><i class="fas fa-save"> SIMPAN</i></button>
    </form>
    <br>
  </div>
  <br><br>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
  </script>
</body>

</html>