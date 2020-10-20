<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}
require 'functions.php';
$id = filter_input(INPUT_GET, 'id');
$mutasi = query("SELECT * FROM mutasi WHERE id = $id")[0];
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <link rel="stylesheet" href="../css/formAnggota.css">
  <script src="https://kit.fontawesome.com/8306e7b683.js" crossorigin="anonymous"></script>

  <title>Form Mutasi</title>
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
            <a class="nav-link" href="#">Selamat Datang, <?= filter_var($_SESSION["username"]); ?><span class="sr-only">(current)</span></a>
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
          <?php if (true == (filter_var($_SESSION["sadmin"]))) { ?>
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
    if (updateMutasi(filter_input_array(INPUT_POST)) > 0) { ?>
      <div class="alert alert-success" role="alert">
        Data berhasil diupdate. <a href="mutasi.php" class="alert-link">Klik disini untuk melihat tabel</a>.
        <a href="" onClick="window.location.href=window.location.href">(Klik disini untuk refresh)</a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=window.location.href">
          <span aria-hidden=" true">&times</span>
        </button>
      </div>
    <?php
    } else { ?>
      <div class="alert alert-warning" role="alert">
        Data gagal diupdate. <a href="mutasi.php" class="alert-link">Klik disini untuk melihat tabel</a>.
        <a href="" onClick="window.location.href=window.location.href">(Klik disini untuk refresh)</a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times</span>
        </button>
      </div>
  <?php
    }
  }
  ?>

  <div class="container formcontainer border border-dark">
    <h2 class="alert alert-primary text-center mt-3 font-weight-bold">Form Perubahan</h2>
    <a href="mutasi.php" class="kembali btn btn-secondary ml-2 printInv"><i class="fas fa-arrow-circle-left"> Kembali</i></a>
    <form action="" method="POST" class="font-weight-bold">
      <input type="hidden" name="id" value="<?= filter_var($mutasi["id"]); ?>">
      <div class="form-group">
        <label for="Keterangan">Keterangan : </label>
        <input id="Keterangan" type="text" name="keterangan" class="form-control" placeholder="Masukkan Keterangan Mutasi" required autocomplete="off" value="<?= filter_var($mutasi["keterangan"]); ?>">
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="Tanggal">Tanggal : </label>
            <input id="Tanggal" type="date" name="tanggal" class="form-control" placeholder="Masukkan Tanggal Mutasi" required autocomplete="off" value="<?= filter_var($mutasi["tanggal"]); ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="Kode">Kode : </label>
            <select id="Kode" class="form-control" name="kode">
              <option value="Debit" <?php if ($mutasi["kode"] == "Debit") : ?> selected="selected" <?php endif; ?>>Debit</option>
              <option value="Kredit" <?php if ($mutasi["kode"] == "Kredit") : ?> selected="selected" <?php endif; ?>>Kredit</option>
            </select>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="Jumlah">Jumlah : </label>
        <input id="Jumlah" type="number" name="jumlah" class="form-control" placeholder="Dalam Satuan Rupiah dan Tanpa Titik" required autocomplete="off" value="<?= filter_var($mutasi["jumlah"]); ?>">
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