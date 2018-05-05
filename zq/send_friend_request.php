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
        // $fromsid = $_POST['fromsid'];
        // $tosid = $_POST['tosid'];
        // $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }
        // $conn->query("insert into NotificationToStudent values(null, {$tosid}, 'unread', 'FriendReq');");
        // $insertednid = $conn->query("select ns.nid from NotificationToStudent ns where ns.tosid = {$tosid} and ns.notificationtype='FriendReq';")->fetch_assoc()['nid'];
        // echo $insertednid;
        // $conn->query("insert into FriendReq values({$insertednid}, now(), {$fromsid}, {$tosid}, 'pending');");
        ?>
        <p>Friend request send</p>
        <a href="javascript:history.go(-2)">GO BACK</a>
    </body>
</html>
