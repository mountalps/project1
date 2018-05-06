<?php
include_once '../lib/fun.php';
include_once '../lib/dbinfo.php';
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
            $sid1 = $_POST['sid1'];
            $sid2 = $_POST['sid2'];
            if ((int)$sid1 > (int)$sid2) {
                $conn->query("delete from Friend where sid1 = {$sid2} and sid2 = {$sid1};");
                $conn->query("delete from NotificationToStudent where (fromsid = {$sid1} and tosid = {$sid2}) or (fromsid = {$sid2} and tosid = {$sid1});");
            } else if ((int)$sid1 > (int)$sid2) {
                $conn->query("delete from Friend where sid1 = {$sid1} and sid2 = {$sid2};");
                $conn->query("delete from NotificationToStudent where (fromsid = {$sid1} and tosid = {$sid2}) or (fromsid = {$sid2} and tosid = {$sid1});");
            }
            header("Location: student_friends_page.php");
            exit;
        ?>
    </head>
    <body>
    </body>
</html>
