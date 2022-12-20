<?php
// pertemuan 16
session_start();

if (!isset($_SESSION['login'])) {
  header('Location: login.php');
  exit;
}
// End of Pertemuan 16

require 'functions.php';

if (isset($_POST['kirim'])) :
  if (tambah($_POST) > 0) :
    echo "<script>
          alert('Data berhasil ditambahkan!');
          document.location.href = 'index.php';
          </script>";
  else :
    echo "<script>
          alert('Data gagal ditambahkan!');
          document.location.href = 'tambah.php';
          </script>";
  endif;
endif;
?>

<html>

<head>
  <title></title>
</head>

<body>
  <h3>Tambah Data Mahasiswa</h3>
  <form action="" method="post" enctype="multipart/form-data">
    <table>
      <tr>
        <td>Nama</td>
        <td><input type="text" name="nama"></td>
      </tr>
      <tr>
        <td>NRP</td>
        <td><input type="text" name="nrp"></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><input type="email" name="email"></td>
      </tr>
      <tr>
        <td>Jurusan</td>
        <td><input type="text" name="jurusan"></td>
      </tr>
      <tr>
        <td>Gambar</td>
        <td><input type="file" name="gambar"></td>
      </tr>
      <tr>
        <td></td>
        <td><button type="submit" name="kirim">Input</button></td>
      </tr>
    </table>
  </form>
</body>

</html>