<?php
include_once '../lib/fun.php';
include_once '../lib/dbinfo.php';
$checkUser = checkLogin();
//    var_dump($checkUser);
if ($checkUser != "student"){
    header('Location: 0_company-homepage.php');
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
            $username1 = $_POST['username'];
            $cid = $_POST['cid'];
            if ($username == $username1) {
                $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sid = $conn->query("select sid from Student where username = '$username';")->fetch_assoc()['sid'];
                $conn->query("delete from Follow where sid = {$sid} and cid = {$cid};");
                // $conn->query("insert into Follow values({$sid}, {$cid});");
            } else {
                header("Location: ../index.html");
                exit;
            }
            header("Location: student_followed_companies.php");
            exit;
        ?>
    </head>
    <body>

    </body>
</html>
