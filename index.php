<?php
// pertemuan 16
session_start();
require 'functions.php';

if (!isset($_SESSION['login'])) {
  header('Location: login.php');
  exit;
}
// End of Pertemuan 16

$jumlahDataPerHalaman = 3;
$jumlahData           = count(query("SELECT * FROM mahasiswa"));
$jumlahHalaman        = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif         = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
$awalData             = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerHalaman");

if (isset($_POST['cari'])) {
  $mahasiswa = cari($_POST['keyword']);
}
?>

<html>

<head>
  <title>Daftar Mahasiswa</title>
  <style>
    img {
      width: 50px;
    }

    a {
      text-decoration: none;
    }
  </style>
</head>

<body>
  <h1>Daftar Mahasiswa</h1>
  <h3><a href="tambah.php">Tambah Data Mahasiswa</a></h3>

  <form action="" method="post">
    <input type="text" name="keyword" autofocus autocomplete='off' size="40" placeholder="masukkan keyword pencarian...">
    <button type="submit" name="cari">Cari</button>
  </form>

  <?php if ($halamanAktif > 1) : ?>
    <a href="?halaman= <?php echo $halamanAktif - 1; ?>"> &lt; </a>
  <?php endif; ?>

  <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>

    <?php if ($i == $halamanAktif) : ?>
      <a href="?halaman= <?php echo $i; ?>" style='font-weight: bold; color: red;'> <?php echo $i; ?></a>
    <?php else : ?>
      <a href="?halaman= <?php echo $i; ?>"> <?php echo $i; ?></a>
    <?php endif; ?>
  <?php endfor; ?>

  <?php if ($halamanAktif < $jumlahHalaman) : ?>
    <a href="?halaman= <?php echo $halamanAktif + 1; ?>"> &gt; </a>
  <?php endif; ?>



  <table border="1" ceppadding="10" cellspacing="0">
    <tr>
      <th>No</th>
      <th>Aksi</th>
      <th>Gambar</th>
      <th>NRP</th>
      <th>Nama</th>
      <th>Email</th>
      <th>Jurusan</th>
    </tr>

    <?php $i = 1; ?>
    <?php foreach ($mahasiswa as $mhs) : ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td>
          <a href="ubah.php?id=<?php echo $mhs['id']; ?>">Ubah</a> |
          <a href="hapus.php?id=<?php echo $mhs['id']; ?>" onclick="return confirm('Yakin?');">hapus</a>
        </td>
        <td><img src="img/<?php echo $mhs['gambar']; ?>"></td>
        <td><?php echo $mhs['nrp']; ?></td>
        <td><?php echo $mhs['nama']; ?></td>
        <td><?php echo $mhs['email']; ?></td>
        <td><?php echo $mhs['jurusan']; ?></td>
      </tr>
      <?php $i++; ?>
    <?php endforeach; ?>
  </table>
  <a href="logout.php">Logout</a>
</body>

</html>