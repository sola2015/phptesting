<?php

#Start session
session_start();

#Database Connection
include('./setting/startup.php');

if ($_POST) {

    $q = "SELECT * FROM users WHERE email = '$_POST[email]' AND password = SHA1('$_POST[password]')";
    $r = mysqli_query($dbc, $q);
    $s = mysqli_fetch_assoc($r);

    if (mysqli_num_rows($r) == 1) {

        $_SESSION['username'] = $s['email'];
        $_SESSION['userstatus'] = $s['status'];
        $_SESSION['userid'] = $s['id'];
        header('Location: index.php');

    }

}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Admin Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php include('./setting/css.php'); ?>
    <?php include('./setting/js.php'); ?>

</head>
<body>


<div class="container">


    <div class="row">

        <div class="col-md-4 col-md-offset-4">

            <div class="panel panel-info">

                <div class="panel-heading">

                    <strong>Login</strong>

                </div><!--End panel heading-->

                <div class="panel-body">

                    <form action="login.php" method="post" role="form">
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Password">
                        </div>

                        <!--    <div class="checkbox">-->
                        <!--        <label>-->
                        <!--            <input type="checkbox"> Check me out-->
                        <!--        </label>-->
                        <!--    </div>-->

                        <button type="submit" class="btn btn-default">Submit</button>

                        <button type="button" class="btn btn-link"><a href="../index.php">Homepage</a></button>

                    </form>

                </div><!--End Panel Body-->

            </div><!--End Panel-->


        </div><!--End col-->

    </div><!--End Row-->

</div>


<?php //include(D_TEMPLATE . '/footer.php')//main footer;?>

<?php //if($debug == 1){include ('widgets/debug.php');}?>


</body>


</html>