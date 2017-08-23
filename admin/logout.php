<?php

#Start session
session_start();

unset($_SESSION['username']);//Delete username key

//session_destroy();//Delete all the session keys

header('Location: login.php');//Redirect to

?>

