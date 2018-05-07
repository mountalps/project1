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
            $jid = $_POST['jid'];
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $fromsid = $_POST['fromsid'];
            foreach ($_POST['forwardfriends'] as $sid) {
                $time = date("Y-m-d H:i:s");
                $conn->query("insert into NotificationToStudent values(null, {$fromsid}, null, {$sid}, 'unread', '{$time}', 'Forward');");
                $nid = $conn->query("select nid from NotificationToStudent where fromsid={$fromsid} and tosid={$sid} and ntime='{$time}' and notificationtype='Forward';")->fetch_assoc()['nid'];
                while ($nid == ""){
                    $nid = $conn->query("select nid from NotificationToStudent where fromsid={$fromsid} and tosid={$sid} and ntime='{$time}' and notificationtype='Forward');")->fetch_assoc()['nid'];
                }
                $conn->query("insert into Forward values({$nid}, {$jid}, '{$time}');");
            }

        ?>
    </head>
    <body>
        <p>Friend request send</p>
        <a href="javascript:history.go(-2)">GO BACK</a>
    </body>
</html>
