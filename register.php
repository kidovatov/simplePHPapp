<?php
// pertemuan 16
session_start();

if (!isset($_SESSION['login'])) {
  header('Location: login.php');
  exit;
}
// End of Pertemuan 16

require 'functions.php';
if (isset($_POST['daftar'])) {
  if (registrasi($_POST) > 0) {
    echo "<script>
        alert('user baru berhasil ditambahkan ke database!);      
    </script>";
  } else {
    echo mysqli_error($conn);
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Registrasi</title>
</head>

<body>
  <h3>Halaman Registrasi</h3>
  <form action="" method="post">
    <table>
      <tr>
        <td>Username</td>
        <td><input type="text" name="username"></td>
      </tr>
      <tr>
        <td>Password</td>
        <td><input type="password" name="password"></td>
      </tr>
      <tr>
        <td>Ulangi Password</td>
        <td><input type="password" name="password2"></td>
      </tr>
      <tr>
        <td></td>
        <td><button type="submit" name="daftar">Daftar</button></td>
      </tr>
    </table>
  </form>
</body>

</html>