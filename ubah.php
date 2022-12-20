<?php
// pertemuan 16
session_start();

if (!isset($_SESSION['login'])) {
  header('Location: login.php');
  exit;
}
// End of Pertemuan 16

require 'functions.php';

$id = $_GET['id'];

$mahasiswa = query("SELECT * FROM mahasiswa WHERE id = '$id'")[0];

if (isset($_POST['kirim'])) :
  if (ubah($_POST) > 0) :
    echo "<script>
          alert('Data berhasil diubah!');
          document.location.href = 'index.php';
          </script>";
  else :
    echo "<script>
          alert('Data gagal diubah!');
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
  <h3>Ubah Data Mahasiswa</h3>
  <form action="" method="post" enctype="multipart/form-data">
    <table>
      <tr>
        <td><input type="hidden" name='id' value=<?php echo $mahasiswa['id']; ?>></td>
        <td><input type="hidden" name="gambarLama" value=<?php echo $mahasiswa['gambar']; ?>></td>
      </tr>
      <tr>
        <td>Nama</td>
        <td><input type="text" name="nama" value=<?php echo $mahasiswa['nama']; ?>></td>
      </tr>
      <tr>
        <td>NRP</td>
        <td><input type="text" name="nrp" value=<?php echo $mahasiswa['nrp']; ?>></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><input type="email" name="email" value=<?php echo $mahasiswa['email']; ?>></td>
      </tr>
      <tr>
        <td>Jurusan</td>
        <td><input type="text" name="jurusan" value=<?php echo $mahasiswa['jurusan']; ?>></td>
      </tr>
      <tr>
        <td>Gambar</td>
        <td><input type="file" name="gambar" value=<?php echo $mahasiswa['gambar']; ?>></td>
      </tr>
      <tr>
        <td></td>
        <td><button type="submit" name="kirim">Input</button></td>
      </tr>
    </table>
  </form>
</body>

</html>