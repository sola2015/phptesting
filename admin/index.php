<?php

# Start the session
session_start();

# Check if the user is admin
if ($_SESSION['userstatus'] != 1 or $_SESSION['username'] == null) {//if the user is not an admin, go to login.php
    header('Location: login.php');
}

include('setting/startup.php');
$page_no = 1;

?>

<!DOCTYPE html>
<html>
<head>

    <title>VAPS</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php include('./setting/css.php'); ?>
    <?php include('./setting/js.php'); ?>

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

<!--Start body content-->
<div class="container">
    <h1>Personal Detail</h1>

    <?php
    #UPDATE profile
    switch ($_POST['submitted']) {

        case 1: {
            $fname = mysqli_real_escape_string($dbc, $_POST['fname']);
            $lname = mysqli_real_escape_string($dbc, $_POST['lname']);
            $dob = mysqli_real_escape_string($dbc, $_POST['dob']);
            $phone = mysqli_real_escape_string($dbc, $_POST['phone']);
            $street = mysqli_real_escape_string($dbc, $_POST['street']);
            $suburb = mysqli_real_escape_string($dbc, $_POST['suburb']);
            $state = mysqli_real_escape_string($dbc, $_POST['state']);
            $zip = mysqli_real_escape_string($dbc, $_POST['zip']);
            $qualify = mysqli_real_escape_string($dbc, $_POST['qualify']);

            $q = "UPDATE users SET first = '$fname', last = '$lname', dob = '$dob', phone = '$phone', street = '$street', suburb = '$suburb', state = '$state', zip = '$zip', qualify = '$qualify' WHERE id = $_SESSION[userid]";

            break;

        }

        case 2: {


        }


    }

    $r = mysqli_query($dbc, $q);

    if ($r) {
        $message = '<p>Updated!</p>';

    } else {
        $message = '<p>' . mysqli_error($dbc);
        $message .= '<p>' . $q . '</p>';
    }

    if (isset($message)) {
        echo $message;
    }

    ?>


<!--main content-->

    <div class="col-md-7">

        <?php
        #Select user information from database
        $q = "SELECT * FROM users LEFT JOIN user_status ON users.status = user_status.status WHERE users.id = $_SESSION[userid]";
        $r = mysqli_query($dbc, $q);
        $userDetail = mysqli_fetch_assoc($r);
        ?>

        <!--tab menu-->
        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#profile">Profile</a></li>
            <li><a href="#password">Password</a></li>
            <li><a href="#member">Member Status</a></li>
        </ul>

        <!--tab content-->
        <div class="tab-content">

            <!--tab 1-->
            <div class="tab-pane active" id="profile">
                <br><br>

                <form action="index.php" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label">First name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="fname"
                                   value="<?php echo $userDetail['first']; ?>" placeholder="Type here">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lname" class="col-sm-3 control-label">Last name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="lname"
                                   value="<?php echo $userDetail['last']; ?>" placeholder="Type here">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dob" class="col-sm-3 control-label">Date of birth</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="dob" value="<?php echo $userDetail['dob']; ?>"
                                   placeholder="Type here">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-sm-3 control-label">Phone number</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="phone"
                                   value="<?php echo $userDetail['phone']; ?>" placeholder="Type here">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="street" class="col-sm-3 control-label">Street</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="street"
                                   value="<?php echo $userDetail['street']; ?>" placeholder="Type here">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="suburb" class="col-sm-3 control-label">Suburb</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="suburb"
                                   value="<?php echo $userDetail['suburb']; ?>" placeholder="Type here">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="state" class="col-sm-3 control-label">State</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="state"
                                   value="<?php echo $userDetail['state']; ?>" placeholder="Type here">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="zip" class="col-sm-3 control-label">Zip code</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="zip" value="<?php echo $userDetail['zip']; ?>"
                                   placeholder="Type here">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="qualify" class="col-sm-3 control-label">Qualification</label>
                        <div class="col-sm-9">
                            <textarea type="text" rows="8" class="form-control" name="qualify"
                                      placeholder="Type here"><?php echo $userDetail['qualify']; ?></textarea>
                        </div>
                    </div>
                    <!--Save button-->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Save</button>
                            <input type="hidden" name="submitted" value="1">
                            <input type="hidden" name="id" value="<?php echo $userDetail['id']; ?>">
                        </div>
                    </div>
                </form>
            </div>

            <!--            tab 2-->
            <div class="tab-pane" id="password">

                <br><br>

                <form action="chgpas.php" method="post" class="form-horizontal">
                    <fieldset disabled>
                    <div class="form-group">
                        <label for="cemail" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="cemail"
                                   value="<?php echo $userDetail['email']; ?>" placeholder="Keep blank if not changing">
                        </div>
                    </div>
                    </fieldset>
                    <div class="form-group">
                        <label for="npassword" class="col-sm-3 control-label">New Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="npassword" id="npassword"
                                   value="" placeholder="Keep blank if not changing">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="npassword2" class="col-sm-3 control-label">Confirm Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="npassword2" id="npassword2"
                                   value="" placeholder="Retype your new password here when changing">
                        </div>
                    </div>

                    <!--Save button-->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success" onclick="javascript:return check_pass()">Save</button>
                            <input type="hidden" name="submitted" value="2">
                            <input type="hidden" name="id" value="<?php echo $userDetail['id']; ?>">
                        </div>
                    </div>
                </form>

            </div>

            <!--tab 3-->
            <div class="tab-pane" id="member">

                <br><br>

                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Account type:</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo $userDetail['description'];?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Expire date:</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">
                                <?php
                                if ($userDetail['expire'] == null){
                                    echo 'Permanent';
                                }else{
                                    echo $userDetail['expire'];
                                }
                                ?></p>
                        </div>
                    </div>
                </form>



            </div>
        </div>


    </div>
    <!--    End side bar menu-->


</div>
<!--End Body Content-->

<!--Start Footer-->
<footer class="footer">

    <p> Copyright © <?php echo date('Y'); ?> · All Rights Reserved · Victorian Association for Philosophy in Schools</p>

</footer>
<!--End Footer-->

</body>


</html>