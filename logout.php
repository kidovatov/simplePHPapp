<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();

// PERTEMUAN 17 hancurkan cookie
setcookie('id', '', time() - 3600);
setcookie('key', '', time() - 3600);
// END OF PERTEMUAN 17

header("Location: login.php");
exit;
