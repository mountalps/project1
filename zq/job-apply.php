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
            $jid = $_POST['jid'];
            $sid = $_POST['sid'];
            $cid = $_POST['cid'];
            session_start();
            $username = $_SESSION['user'];
            $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            // sleep(1);
            echo $sid;
            echo $jid;
            echo $cid;
            if ($conn->query("select * from Application where fromsid = {$sid} and tocid = {$cid} and jid = {$jid};")->num_rows == 0) {
                var_dump($sid);
                var_dump($jid);
                var_dump($cid);
                $conn->query("insert into Application values(now(), {$sid}, {$cid}, {$jid}, 'unread');");
            }
            header("Location: student_applied_jobs.php");
            exit;
        ?>
    </head>
    <body>
    </body>
</html>
