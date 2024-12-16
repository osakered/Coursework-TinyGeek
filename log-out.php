<?php
include('./assets/scripts/db_connect.php');
session_start();
$login = $_SESSION['login'];
$sql = "SELECT * FROM Users WHERE login = '".$_SESSION['login']."'";
$result = mysqli_query($link, $sql);
$roledata = mysqli_fetch_all($result);
$role = $roledata[0][5];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

header('Location: main.php');
exit();
?>