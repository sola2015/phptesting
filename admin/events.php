<?php


# Start the session
session_start();

# Check if the user is admin
if ($_SESSION['userstatus'] != 1 or $_SESSION['username'] == null) {//if the user is not an admin, go to login.php
    header('Location: login.php');
}

include('setting/startup.php');
$page_no = 3;

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

<!--Start body content-->

<div class="container">
    <div class="row">
        <h1>Events Admin</h1>
        <div class="col-md-3">


            <?php
            #INSERT and UPDATE
            if ($_POST['submitted'] == 1) {

                $title = mysqli_real_escape_string($dbc, $_POST['title']);
                $content = mysqli_real_escape_string($dbc, $_POST['content']);
                $place = mysqli_real_escape_string($dbc, $_POST['place']);
                $cost = mysqli_real_escape_string($dbc, $_POST['cost']);

                if ($_POST['status'] == '') {
                    $status = 1;
                } else {
                    $status = $_POST['status'];
                }

                if ($_POST['sdate'] == '') {
                    $sdate = date('Y-m-d');
                } else {
                    $sdate = $_POST['sdate'];
                }

                if ($_POST['stime'] == '') {
                    $stime = '00:00:00';
                } else {
                    $stime = $_POST['stime'];
                }

//                if ($_POST['edate'] == '') {
//                    $edate = 'null';
//                } else {
//                    $edate = $_POST['edate'];
//                }
//
//                if ($_POST['etime'] == '') {
//                    $etime = "null";
//                } else {
//                    $etime = $_POST['etime'];
//                }

                if ($_GET['id'] == 0) {
                    $q1 = "INSERT INTO events (title, status, place, cost, sdate, stime, content) VALUES('$title', $status, '$place', '$cost', '$sdate', '$stime', '$content')";
                } else {
                    $q1 = "UPDATE events SET title = '$title', status = $status, place = '$places', cost = '$cost', sdate = '$sdate', stime = '$stime', content = '$content' WHERE id = $_GET[id]";
                }

                $r = mysqli_query($dbc, $q1);

                if ($r) {
                    $message = '<p>Updated!</p>';

                } else {
                    $message = '<p>Error: ' . mysqli_error($dbc);
                    $message .= '<p>' . $q1 . '</p>';
                }
#DELETE
            } elseif ($_POST['submitted'] == 2) {

                $q = "DELETE FROM events WHERE id = $_POST[id]";
                $r = mysqli_query($dbc, $q);

            }

            ?>

            <div class="list-group">

                <!--id=0 means adding new page-->
                <a class="list-group-item" href="events.php?id=0">

                    <h4 class="list-group-item-heading"><i class="fa fa-plus"></i>New event</h4>

                </a>


                <?php

                #Start listing from database
                $q4 = "SELECT * FROM events ORDER BY id DESC";
                $r4 = mysqli_query($dbc, $q4);

                while ($page_list = mysqli_fetch_assoc($r4)) {

                    $blurb = substr(strip_tags($page_list['content']), 0, 30);

                    ?>

                    <a href="events.php?id=<?php echo $page_list['id']; ?>" class="list-group-item
                <?php if ($page_list['id'] == $_GET['id']) {
                        echo 'active';
                    } ?>">

                        <h4 class="list-group-item-heading"><?php echo $page_list['title']; ?></h4>

                        <p class="list-group-item-text"><?php echo $blurb; ?></p>

                    </a>

                <?php } ?>

            </div>

        </div>

        <div class="col-md-8">

            <?php

            if (isset($message)) {
                echo $message;
            }

            if (isset($_GET['id'])) {

                $q = "SELECT * FROM events WHERE id = $_GET[id]";
                $r = mysqli_query($dbc, $q);

                $opened = mysqli_fetch_assoc($r);

            }

            ?>

            <form action="events.php?id=<?php
            if ($opened['id'] == '') {
                $opened['id'] = 0;
            }
            echo $opened['id'];

            ?>" method="post" role="form">

                <div class="row">
                    <div class="col-md-6 form-group">

                        <label for="title">Title:</label>
                        <input class="form-control" type="text" name="title" id="title"
                               value="<?php echo $opened['title']; ?>"
                               placeholder="Event Title">

                    </div>
                    <div class="form-group">

                        <label for="status">Status:</label>
                        <br>
                        <?php
                        $q2 = "SELECT * FROM event_status ORDER BY status DESC";
                        $r2 = mysqli_query($dbc, $q2);

                        while ($s2 = mysqli_fetch_assoc($r2)) {
                            ?>
                            <label class="radio-inline">
                                <input type="radio" name="status" id="status"
                                       value="<?php echo $s2['status']; ?>"
                                    <?php
                                    if ($s2['status'] == $opened['status']) {
                                        echo ' checked';
                                    }
                                    ?>>
                                <?php echo $s2['description']; ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">

                        <label for="place">Place:</label>
                        <input class="form-control" type="text" name="place" id="place"
                               value="<?php echo $opened['place']; ?>" placeholder="Held place">

                    </div>
                    <div class="col-md-6 form-group">

                        <label for="cost">Cost:</label>
                        <input class="form-control" type="text" name="cost" id="cost"
                               value="<?php echo $opened['cost']; ?>" placeholder="Cost">

                    </div>
                </div>

                <div>
                    <div class="col-md-6 form-group">

                        <label for="sdate">Start date:</label>
                        <input class="form-control" type="date" name="sdate" id="sdate"
                               value="<?php echo $opened['sdate']; ?>"
                               placeholder="Start date, keep blank if the date is today">

                    </div>
                    <div class="col-md-6 form-group">

                        <label for="stime">Start time:</label>
                        <input class="form-control" type="time" name="stime" id="stime"
                               value="<?php echo $opened['stime']; ?>" placeholder="Start time">

                    </div>
                </div>
<!--                <div>-->
<!--                    <div class="col-md-6 form-group">-->
<!---->
<!--                        <label for="edate">End date:</label>-->
<!--                        <input class="form-control" type="date" name="edate" id="edate"-->
<!--                               value="--><?php //echo $opened['edate']; ?><!--" placeholder="End date">-->
<!---->
<!--                    </div>-->
<!--                    <div class="col-md-6 form-group">-->
<!---->
<!--                        <label for="etime">End time:</label>-->
<!--                        <input class="form-control" type="time" name="etime" id="etime"-->
<!--                               value="--><?php //echo $opened['etime']; ?><!--" placeholder="End time">-->
<!---->
<!--                    </div>-->
<!--                </div>-->

                <div class="form-group">

                    <label for="content">Content:</label>
                    <textarea class="form-control editor" name="content" id="content" rows="8"
                              placeholder="content"><?php echo $opened['content']; ?></textarea>

                </div>

                <!--            SAVE button-->
                <button type="submit" class="btn btn-default">SAVE</button>
                <input type="hidden" name="submitted" value="1">
                <input type="hidden" name="id" value="<?php echo $opened['id']; ?>">

            </form>

            <!--        DELETE button-->
            <div class="pull-right">
                <form action="events.php?id=<?php echo $opened['id']; ?>" method="post">

                    <button class="btn btn-danger <?php
                    if ($_GET['id'] == 0 or $_SESSION['userstatus'] != 1) {
                        echo 'hidden';
                    }
                    ?>" onclick="javascript:return del()"><i class="fa fa-trash-o"></i></button>
                    <input type="hidden" name="submitted" value="2">
                    <input type="hidden" name="id" value="<?php echo $opened['id']; ?>">
                </form>
            </div>


        </div>


    </div>
</div>
<!--End Body Content-->

<!--Start Footer-->
<footer class="footer">

    <p> Copyright © <?php echo date('Y'); ?> · All Rights Reserved · Victorian Association for Philosophy in Schools</p>

</footer>
<!--End Footer-->

</body>


</html>