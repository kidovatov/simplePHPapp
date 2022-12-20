<?php
$conn = mysqli_connect('localhost', 'root', '', 'phpdasar');

function query($query)
{
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows   = [];
  //   $row => baju yg diambil setiap loopingnya
  while ($row = mysqli_fetch_assoc($result)) :

    // $rows[] => wadah
    // $row => baju yang disimpan ke wadah
    // $row => menambahkan tiap elemen baru ke array
    $rows[] = $row;
  endwhile;

  return $rows;
}

function tambah($data)
{
  global $conn;
  // function tambah menerima inputan data karena data dimasukkan sbg parameter
  $nrp      = htmlspecialchars($data['nrp']);
  $nama     = htmlspecialchars($data['nama']);
  $email    = htmlspecialchars($data['email']);
  $jurusan  = htmlspecialchars($data['jurusan']);

  // upload gambar
  $gambar = upload();
  if (!$gambar) {
    return false;
  }

  $query    = "INSERT INTO mahasiswa VALUES ('', '$nama', '$nrp', '$email', '$jurusan', '$gambar')";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function upload()
{
  $namaFile   = $_FILES['gambar']['name'];
  $ukuranFile = $_FILES['gambar']['size'];
  $error      = $_FILES['gambar']['error'];
  $tmpName    = $_FILES['gambar']['tmp_name'];

  // cek apakah tidak ada gambar yang diupload
  if ($error === 4) {
    echo "<script>
          alert('Gambar gagal ditambahkan');
          </script>";
    return false;
  }

  // cek apakah yang diupload adalah gambar
  $ekstensiGambarValid  = ['jpg', 'jpeg', 'png'];
  $ekstensiGambar       = explode('.', $namaFile);
  $ekstensiGambar       = strtolower(end($ekstensiGambar));

  if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
    echo "<script>
          alert('yang Anda upload bukan gambar!');
          </script>";
    return false;
  }

  // cek jika ukurannya terlalu besar
  if ($ukuranFile > 1000000) {
    echo "<script>
          alert('gambar terlalu besar!');
          </script>";
    return false;
  }

  // lolos pengecekan gambar siap diupload
  // generate nama baru
  $namaFileBaru = uniqid();
  $namaFileBaru .= '.';
  $namaFileBaru .= $ekstensiGambar;

  move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
  return $namaFileBaru;
}

function hapus($id)
{
  global $conn;
  $query = "DELETE FROM mahasiswa WHERE id = '$id'";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function ubah($data)
{
  global $conn;
  // function tambah menerima inputan data karena data dimasukkan sbg parameter
  $id       = $data['id'];
  $nrp      = htmlspecialchars($data['nrp']);
  $nama     = htmlspecialchars($data['nama']);
  $email    = htmlspecialchars($data['email']);
  $jurusan  = htmlspecialchars($data['jurusan']);
  $gambarLama   = htmlspecialchars($data['gambarLama']);

  // cek apakah user pilih gambar baru atau tidak
  if ($_FILES['gambar']['error'] === 4) {
    $gambar = $gambarLama;
  } else {
    $gambar = upload();
  }
  $query    = "UPDATE mahasiswa SET 
              nama  = '$nama',
              nrp   = '$nrp', 
              email = '$email', 
              jurusan = '$jurusan', 
              gambar  = '$gambar'
              WHERE id = '$id'
              ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function cari($keyword)
{
  $query = "SELECT * FROM mahasiswa WHERE
    nama LIKE '%$keyword%' OR
    nrp LIKE '%$keyword%' OR
    jurusan LIKE '%$keyword%' OR
    email LIKE '%$keyword%'
  ";
  return query($query);
}

function registrasi($data)
{
  global $conn;
  $username = strtolower(stripslashes($data['username']));
  $password = mysqli_real_escape_string($conn, $data['password']);
  $password2 = mysqli_real_escape_string($conn, $data['password2']);

  // cek username sudah ada atau belum
  $query  = "SELECT username FROM user WHERE username = '$username'";
  $result = mysqli_query($conn, $query);
  if (mysqli_fetch_assoc($result)) {
    echo "<script>
          alert('Username sudah terdaftar');
          </script>";
    return false;
  }

  // cek konfirmasi password
  if ($password != $password2) {
    echo "<script>
          alert('password tidak sesuai!');
          </script>";
    return false;
  }

  // enkripsi password
  $password = password_hash($password, PASSWORD_DEFAULT);

  // tambahkan userbaru ke database
  $tambahUser = "INSERT INTO user VALUES ('', '$username', '$password')";
  mysqli_query($conn, $tambahUser);

  return mysqli_affected_rows($conn);
}
