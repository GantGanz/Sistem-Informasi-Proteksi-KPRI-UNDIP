<?php
session_start();
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

require 'functions.php';

if (isset($_POST["login"])) {
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');

    $result = mysqli_query($conn, "SELECT * FROM user WHERE BINARY username = '$username' AND password = '$password'");

    $level = mysqli_fetch_assoc($result);
    if ($level != null) {
        if ($level['level'] == 1) {
            $_SESSION["sadmin"] = true;
        }
    }

    if (mysqli_num_rows($result) === 1) {
        $_SESSION["login"] = true;
        $_SESSION["username"] = $username;
        header("Location: index.php");
        exit;
    }

    $error = true;
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/login.css">
    <script src="https://kit.fontawesome.com/8306e7b683.js" crossorigin="anonymous"></script>

    <title>Login</title>
</head>

<body>

    <?php if (isset($error)) { ?>
        <div class="alert alert-danger fixed-top" role="alert">
            Username atau Password Salah!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times</span>
            </button>
        </div>
    <?php
    } ?>
    <div class="container mt-5 text-center">
        <h1>Sistem Informasi Proteksi Online</h1>
        <h2>KPRI Universitas Diponegoro</h2>
    </div>
    <div class="container containerbox">
        <img src="../img/logo_koperasi.png" alt="logo_koperasi" class="logo_koperasi">
        <br>
        <hr>
        <form action="" method="POST">
            <div class="form-group">
                <label for="Username">Username : </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                    </div>
                    <input type="text" name="username" id="Username" class="form-control" placeholder="Masukkan Username Anda">
                </div>
            </div>
            <div class="form-group">
                <label for="Password">Password : </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-unlock-alt"></i></div>
                    </div>
                    <input type="password" name="password" id="Password" class="form-control" placeholder="Masukkan Username Anda">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2 buttonSimpan" name="login">Masuk</button>
        </form>
    </div>
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