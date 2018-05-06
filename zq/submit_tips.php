<?php
include_once '../lib/fun.php';
include_once '../lib/dbinfo.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <?php
            $fromsid = $_POST['fromsid'];
            $tosid = $_POST['tosid'];
            $text = $_POST['tips-area'];
            session_start();
            $username = $_SESSION['user'];
            $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
            $usersid = ($conn->query("select sid from Student where username = '{$username}';"))->fetch_assoc()['sid'];
            if ($usersid == $fromsid) {
                $timeinserted = date("Y-m-d H:i:s");
                $conn->query("insert into NotificationToStudent values(null, {$fromsid}, null, {$tosid}, 'unread', '{$timeinserted}', 'Tips');");
                $result = $conn->query("select ns.nid from NotificationToStudent ns where ns.fromsid = {$fromsid} and ns.tosid = {$tosid} and ns.nstatus = 'unread' and ns.notificationtype = 'Tips' and ns.ntime = '{$timeinserted}';")->fetch_assoc();
                while ($result == []) {
                    $result = $conn->query("select ns.nid from NotificationToStudent ns where ns.fromsid = {$fromsid} and ns.tosid = {$tosid} and ns.nstatus = 'unread' and ns.notificationtype = 'Tips' and ns.ntime = '{$timeinserted}';")->fetch_assoc();
                }
                $nid = $result['nid'];
                $conn->query("insert into Tips values({$nid}, '{$text}', '{$timeinserted}');");
            }
        ?>
        <p>Tips sent</p>
        <a href="javascript:history.go(-2)">GO BACK</a>
    </body>
</html>
