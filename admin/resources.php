<?php

# Start the session
session_start();

# Check if the user is admin
if ($_SESSION['userstatus'] != 1 or $_SESSION['username'] == null) {//if the user is not an admin, go to login.php
    header('Location: login.php');
}

include('setting/startup.php');
$page_no = 4;

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


switch ($_POST['submitted']) {

    case 1: {
#INSERT and UPDATE
        $title = mysqli_real_escape_string($dbc, $_POST['title']);
        $content = mysqli_real_escape_string($dbc, $_POST['content']);
//        $cover = mysqli_real_escape_string($dbc, $_POST['cover']);
        $access = mysqli_real_escape_string($dbc, $_POST['access']);
        if ($_POST['date'] == null) {
            $date = date('Y-m-d');
        } else {
            $date = $_POST['date'];
        }


        if ($_GET['id'] == 0) {
            $q = "INSERT INTO resources (title, date, content, access) VALUES('$title', '$date', '$content', '$access')";
        } else {
            $q = "UPDATE resources SET title = '$title', date = '$date',  content = '$content', access = '$access' WHERE id = $_GET[id]";
        }

        $r = mysqli_query($dbc, $q);

        if ($r) {
            $message = '<p>Updated!</p>';

        } else {
            $message = '<p>Error: ' . mysqli_error($dbc);
            $message .= '<p>' . $q . '</p>';
        }
        break;
    }


    case 2: {
        #DELETE
        $q = "DELETE FROM resources WHERE id = $_GET[id]";
        $r = mysqli_query($dbc, $q);
        break;

    }


}

?>

<!--Start body content-->

<!--Start Side Bar-->


<div class="container">
    <h1>Resources Admin</h1>
    <div class="col-md-3">
        <div class="list-group">

            <!--id=0 means adding new page-->
            <a class="list-group-item" href="resources.php?id=0">

                <h4 class="list-group-item-heading"><i class="fa fa-plus"></i>New resource</h4>

            </a>


            <?php

            #Start listing all the resources from database
            $q = "SELECT * FROM resources ORDER BY date DESC";
            $r = mysqli_query($dbc, $q);

            while ($page_list = mysqli_fetch_assoc($r)) {

                $blurb = substr(strip_tags($page_list['content']), 0, 30);

                ?>

                <a href="resources.php?id=<?php echo $page_list['id']; ?>" class="list-group-item
                <?php if ($page_list['id'] == $_GET['id']) {
                    echo 'active';
                } ?>">

                    <h4 class="list-group-item-heading"><?php echo $page_list['title']; ?></h4>

                    <p class="list-group-item-text"><?php echo $blurb; ?></p>

                </a>

            <?php } ?>

        </div>

    </div>


    <!--    End Side Bar-->

    <!--    Start right page body-->

    <?php

    if (isset($message)) {
        echo $message;
    }

    if (isset($_GET['id'])) {

        $q = "SELECT * FROM resources JOIN user_status ON resources.access = user_status.status WHERE id = $_GET[id]";

        $r = mysqli_query($dbc, $q);

        $opened = mysqli_fetch_assoc($r);

    }

    ?>


    <div class="col-md-9">

        <!--        Tab-->
        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#words">Content</a></li>
            <li><a href="#cover">Cover picture</a></li>
        </ul>

        <!--        Content Tab-->
        <div class="tab-content">
            <div class="tab-pane active" id="words">

                <form action="resources.php?id=<?php
                if ($opened['id'] == '') {
                    $opened['id'] = 0;
                }
                echo $opened['id'];

                ?>" method="post" role="form">

                    <div class="col-md-6">
                        <!--title-->
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input class="form-control" type="text" name="title" id="title"
                                   value="<?php echo $opened['title']; ?>"
                                   placeholder="Page Title">
                        </div>

                        <!--Date-->
                        <div class="form-group">
                            <label for="date">Updated Date:</label>
                            <input class="form-control" type="date" name="date" id="date"
                                   value="<?php echo $opened['date']; ?>" placeholder="Keep blank if the date is today">
                        </div>

                        <!--Access right control-->
                        <div class="form-group">
                            <label for="access">Access Right:</label>
                            <select class="form-control" id="access" name="access">

                                <?php
                                $q2 = "SELECT * FROM user_status ORDER BY status DESC";
                                $r2 = mysqli_query($dbc, $q2);
                                while ($access_list = mysqli_fetch_assoc($r2)) {
                                    ?>

                                    <option value="<?php echo $access_list['status']; ?>"
                                        <?php if ($access_list['status'] == $opened['access']) {
                                            echo 'selected';
                                        } ?>
                                    >
                                        <?php echo $access_list['description']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <!--Start content-->
                    <div class="form-group col-md-12">

                        <label for="content">Content:</label>
                        <textarea class="form-control editor" name="content" id="content" rows="8"
                                  placeholder="News content"><?php echo $opened['content']; ?></textarea>

                        <!--SAVE button-->
                        <button type="submit" class="btn btn-default">SAVE</button>
                        <input type="hidden" name="submitted" value="1">
                        <input type="hidden" name="id" value="<?php echo $opened['id']; ?>">
                    </div>
                </form>

                <!--DELETE button-->
                <form action="resources.php?id=<?php echo $opened['id']; ?>" method="post">

                    <button class="btn btn-danger pull-right <?php
                    if ($_GET['id'] == 0 or $_SESSION['userstatus'] != 1) {
                        echo 'hidden';
                    }
                    ?>" onclick="javascript:return del()"><i class="fa fa-trash-o"></i></button>
                    <input type="hidden" name="submitted" value="2">
                    <input type="hidden" name="id" value="<?php echo $opened['id']; ?>">
                </form>

            </div>


            <!--Cover picture tab-->
            <div class="tab-pane" id="cover">

                <div class="col-md-9">
                    <!--Start cover page review-->
                    <img src="<?php echo $opened['cover']; ?>" alt="Cover picture" class="img-thumbnail">
                </div>

                <!--Upload cover pic-->
                <div class="col-md-3">
                    <form action="upload.php" method="post" enctype="multipart/form-data"
                          class="<?php if ($opened['id'] == 0) echo 'hidden'; ?>">
                        <label for="file" class="fa fa-upload">Upload new cover:</label>
                        <input type="file" name="file" id="file" onchange="javascript:setImagePreview();">
                        <div id="localImag"><img id="preview" width=-1 height=-1 style="diplay:none"/></div>
                        <br>
                        <input type="submit" name="submit" value="Upload"/>
                        <input type="hidden" name="id" value="<?php echo $opened['id']; ?>">
                    </form>
                </div>
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