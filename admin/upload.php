<?php

include('setting/startup.php');

session_start();

if ($_SESSION['userstatus'] != 1 or $_SESSION['username'] == null) {//if the user is not an admin, go to login.php
    header('Location: login.php');
}
if (1)//这个地方可以填写上传文件的限制，比如格式大小要求等，为了方便测试，这里没有写上传限制。
{
    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";//获取文件返回错误
    } else {
        //打印文件信息
//        echo "Upload: " . $_FILES["file"]["name"] . "<br />";//获取文件名
//        echo "Type: " . $_FILES["file"]["type"] . "<br />";//获取文件类型
//        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";//获取文件大小
//        echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";//获取文件临时地址

        //自定义文件名称
        $array = $_FILES["file"]["type"];
        $array = explode("/", $array);
        $newfilename = time();//自定义文件名
        $_FILES["file"]["name"] = $newfilename . "." . $array[1];
        $file_name_full = "../images/" . $newfilename . "." . $array[1];
        $id = $_POST['id'];

//        if (!is_dir("upload/".$_SESSION["userid"]))//当路径不穿在
//        {
//            mkdir("upload/".$_SESSION["userid"]);//创建路径
//        }
        $url = "../images/";//记录路径
        if (file_exists($url . $_FILES["file"]["name"]))//当文件存在
        {
            echo $_FILES["file"]["name"] . " already exists. ";
        } else//当文件不存在
        {
            $url = $url . $_FILES["file"]["name"];
            move_uploaded_file($_FILES["file"]["tmp_name"], $url);

            $q = "UPDATE resources SET cover = '$file_name_full' WHERE id = $id";
            $r = mysqli_query($dbc, $q);

            $go_to_location = "resources.php?id=" . $id;
            header("Location: $go_to_location");
        }
    }
} else {
    echo "Invalid file";
}

?>