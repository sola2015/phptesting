<?php

# Start the session
session_start();

# Check if the user is admin
if ($_SESSION['userstatus'] != 1 or $_SESSION['username'] == null) {//if the user is not an admin, go to login.php
    header('Location: login.php');
}

include('setting/startup.php');
$page_no = 6;

?>

<!DOCTYPE html>
<html>
<head>

    <title>VAPS</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php include('setting/css.php'); ?>
    <?php include('setting/js.php'); ?>

</head>
<body>

<!--Start nav-->
<nav class="nav navbar-default" role="navigation">
    <ul class="nav navbar-nav">
        <?php

        $q3 = "SELECT * FROM pages";
        $r3 = mysqli_query($dbc, $q3);

        while ($menu = mysqli_fetch_assoc($r3)) {
            ?>

            <li class="<?php if ($menu['id'] == $page_no) {
                echo 'active';
            } ?>">
                <a href="<?php echo $menu['url']; ?>"><?php echo $menu['title']; ?></a>
            </li>

        <?php } ?>

    </ul>

    <div class="pull-right">
        <ul class="nav navbar-nav">

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $user['fullname']; ?><span
                            class="caret"></span></a>
                <ul class="dropdown-menu">

                    <li><a href="logout.php">Logout</a></li>

                </ul>
            </li>
        </ul>
    </div>
</nav>

<!--End nav-->

<?php

$content = mysqli_real_escape_string($dbc, $_POST['content']);

if ($_POST['submitted'] == 1) {

    $q = "UPDATE ethics SET content = '$content'";

    $r = mysqli_query($dbc, $q);

}

$q2 = "SELECT * FROM ethics";

$r2 = mysqli_query($dbc, $q2);

$content = mysqli_fetch_assoc($r2);


?>

<!--Start body content-->




<div class="container">
    <h1>Ethical Capalicities Admin</h1>
    <div class="col-md-10">
        <form action="ethics.php" method="post">
            <label for="content">Content:</label>

            <!--        Text area-->
            <textarea class="form-control editor" name="content" id="content" rows="15"
                      placeholder="Content"><?php echo $content['content']; ?></textarea>
            <!--SAVE button-->
            <button type="submit" class="btn btn-default">SAVE</button>
            <input type="hidden" name="submitted" value="1">
        </form>
    </div>
</div>


<!--Start Footer-->
<footer class="footer">

    <p> Copyright © <?php echo date('Y'); ?> · All Rights Reserved · Victorian Association for Philosophy in Schools</p>

</footer>
<!--End Footer-->

</body>


</html>