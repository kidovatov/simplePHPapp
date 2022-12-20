<?php
// pertemuan 16
session_start();
// End of Pertemuan 16

require 'functions.php';

// Pertemuan 17 set cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
  $id   = $_COOKIE['id'];
  $key  = $_COOKIE['key'];

  // ambil username berdasarkan id
  $query  = "SELECT * FROM user WHERE id = '$id'";
  $result = mysqli_query($conn, $query);
  $row    = mysqli_fetch_assoc($result);

  // cek cookie dan username
  if ($key === hash('sha256', $row['username'])) {
    $_SESSION['login'] = true;
  }
}
// End of pertemuan 17


// pertemuan 16
if (isset($_SESSION['login'])) {
  header('Location: index.php');
  exit;
}
// End of Pertemuan 16



if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = "SELECT * FROM user WHERE username = '$username'";
  $result = mysqli_query($conn, $query);

  // cek username
  if (mysqli_num_rows($result) === 1) {

    // cek password
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {

      // pertemuan 16 set session
      $_SESSION['login'] = true;
      // End of Pertemuan 16

      // pertemuan 17 cek remember me
      if (isset($_POST['remember'])) {
        // buat cookie
        setcookie('id', $row['id'], time() + 60);
        setcookie('key', hash('sha256', $row['username']), time() + 60);
      }
      // End of pertemuan 17

      header("Location: index.php");
      exit;
    }
  }

  $error = true;
}
?>

<html>

<head>
  <title></title>
  <style>
    p {
      color: red;
      font-style: italic;
    }
  </style>
</head>

<body>
  <h1>Halaman Login</h1>

  <?php if (isset($error)) : ?>
    <p>username / password salah!</p>
  <?php endif; ?>

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
        <td><button type="submit" name="login">Login</button></td>
        <td><input type="checkbox" name="remember">Remember Me</td>
      </tr>
    </table>
  </form>
</body>

</html>