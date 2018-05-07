<?php
include_once '../lib/fun.php';
include_once '../lib/dbinfo.php';
$checkUser = checkLogin();
//    var_dump($checkUser);
if ($checkUser != "student"){
    header('Location: 0_student-homepage.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
        <?php
            session_start();
            $username = $_SESSION['user'];
            $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
        ?>
    </head>
    <body>
        <?php
            $deletenid = $_POST['delete-tip'];
            $conn->query("delete from Tips where nid = {$deletenid}");
            $conn->query("delete from NotificationToStudent where nid = {$deletenid}");
            header("Location: student_notifications.php");
            exit;
        ?>
    </body>
</html>
