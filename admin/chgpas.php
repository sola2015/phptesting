<?php
session_start();
include('setting/startup.php');

if ($_SESSION['username'] == null) {
    header('Location: logout.php');
}


if ($_POST['npassword'] != null){

    $password = SHA1($_POST['npassword']);

    $q = "UPDATE users SET password = '$password' WHERE id = $_POST[id]";
    $r = mysqli_query($dbc, $q);

}


header("Location: index.php");


?>