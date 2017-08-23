<?php
include('setting/startup.php');

# Start the session
session_start();

# Check if the user is admin
if ($_SESSION['userstatus'] != 1 or $_SESSION['username'] == null) {//if the user is not an admin, go to login.php
    header('Location: login.php');
}

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
        <li><a href="index.php">Personal Detail</a></li>
        <li class="active"><a href="news.php?id=0">News</a></li>
        <li><a href="events.php?id=0">Events</a></li>
        <li><a href="resources.php?id=0">Resources</a></li>
        <li><a href="mngmem.php">Manage Members</a></li>
        <li><a href="contact.php">Contact</a></li>
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
<h1>News Admin</h1>

<div class="row">

    <div class="col-md-3">


        <?php
#INSERT and UPDATE
        if ($_POST['submitted'] == 1) {

            $title = mysqli_real_escape_string($dbc, $_POST['title']);
            $content = mysqli_real_escape_string($dbc, $_POST['content']);
            if ($_POST['date'] == null) {
                $date = date('Y-m-d');
            } else {
                $date = $_POST['date'];
            }


            if ($_GET['id'] == 0) {
                $q = "INSERT INTO news (title, date, content) VALUES('$title', '$date', '$content')";
            } else {
                $q = "UPDATE news SET title = '$title', date = '$date', content = '$content' WHERE id = $_GET[id]";
            }

            $r = mysqli_query($dbc, $q);

            if ($r) {
                $message = '<p>Updated!</p>';

            } else {
                $message = '<p>Error: ' . mysqli_error($dbc);
                $message .= '<p>' . $q . '</p>';
            }
#DELETE
        }elseif($_POST['submitted'] == 2){

            $q = "DELETE FROM news WHERE id = $_GET[id]";
            $r = mysqli_query($dbc, $q);

        }

        ?>

        <div class="list-group">

            <!--            id=0 means adding new page-->
            <a class="list-group-item" href="news.php?id=0">

                <h4 class="list-group-item-heading"><i class="fa fa-plus"></i>New page</h4>

            </a>


            <?php

            #Start listing all the news from database
            $q = "SELECT * FROM news ORDER BY DATE DESC";
            $r = mysqli_query($dbc, $q);

            while ($page_list = mysqli_fetch_assoc($r)) {

                $blurb = substr(strip_tags($page_list['content']), 0, 30);

                ?>

                <a href="news.php?id=<?php echo $page_list['id']; ?>" class="list-group-item
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

            $q = "SELECT * FROM news WHERE id = $_GET[id]";
            $r = mysqli_query($dbc, $q);

            $opened = mysqli_fetch_assoc($r);

        }

        ?>

        <form action="news.php?id=<?php
        if ($opened['id'] == '') {
            $opened['id'] = 0;
        }
        echo $opened['id'];

        ?>" method="post" role="form">

            <div class="form-group">

                <label for="title">Title:</label>
                <input class="form-control" type="text" name="title" id="title" value="<?php echo $opened['title']; ?>"
                       placeholder="Page Title">

            </div>


            <div class="form-group">

                <label for="date">Updated Date:</label>
                <input class="form-control" type="text" name="date" id="date"
                       value="<?php echo $opened['date']; ?>" placeholder="Keep blank if the date is today">

            </div>

            <div class="form-group">

                <label for="content">Content:</label>
                <textarea class="form-control editor" name="content" id="content" rows="8"
                          placeholder="News content"><?php echo $opened['content']; ?></textarea>

            </div>

            <!--            SAVE button-->
            <button type="submit" class="btn btn-default">SAVE</button>
            <input type="hidden" name="submitted" value="1">
            <input type="hidden" name="id" value="<?php echo $opened['id']; ?>">

        </form>

        <!--        DELETE button-->
        <div class="pull-right">
            <form action=""news.php?id=<?php echo $opened['id'];?>" method="post">

            <button class="btn btn-danger <?php
            if ($_GET['id'] == 0 or $_SESSION['userstatus'] != 1) {
                echo 'hidden';
            }
            ?>" onclick="javascript:return del()" ><i class="fa fa-trash-o"></i></button>
            <input type="hidden" name = "submitted" value="2">

            </form>
        </div>



    </div>


</div>
<!--End Body Content-->

<!--Start Footer-->
<footer class="footer">

    <p> Copyright © <?php echo date('Y');?> · All Rights Reserved · Victorian Association for Philosophy in Schools</p>

</footer>
<!--End Footer-->

</body>


</html>