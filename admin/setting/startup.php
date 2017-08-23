<?php
//php file

error_reporting(0);

# Database connection
$dbc = mysqli_connect('localhost', 'vaps', 'vaps', 'vaps') OR die('Error: ' . mysqli_connect_error());

# Constants:
DEFINE('D_TEMPLATE', 'template');


# Functions:
include('function/data.php');
include('function/template.php');


$site_title = 'VAPS';

if (isset($_GET['id'])) {
    $pageid = $_GET['id'];//set $pageid to the value given in URL
} else {
    $pageid = 1;//Set $pageid to a default id(homepage or 404)
}


#Page setup
$page = data_page($dbc, $pageid);

#User setup
$user = data_user($dbc, $_SESSION['username']);


?>

