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
    </head>
    <body>
        <?php
            $fromsid = $_POST['fromsid'];
            $tosid = $_POST['tosid'];
            $text = htmlspecialchars($_POST['tips-area']);
            session_start();
            $username = $_SESSION['user'];
            $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
            $usersid = ($conn->query("select sid from Student where username = '{$username}';"))->fetch_assoc()['sid'];
            if ($usersid == $fromsid) {
                date_default_timezone_set("America/New_York");
                $timeinserted = date("Y-m-d H:i:s");
                $conn->query("insert into NotificationToStudent values(null, {$fromsid}, null, {$tosid}, 'unread', '{$timeinserted}', 'Tips');");
                $result = $conn->query("select ns.nid from NotificationToStudent ns where ns.fromsid = {$fromsid} and ns.tosid = {$tosid} and ns.nstatus = 'unread' and ns.notificationtype = 'Tips' and ns.ntime = '{$timeinserted}';")->fetch_assoc();
                while ($result == []) {
                    $result = $conn->query("select ns.nid from NotificationToStudent ns where ns.fromsid = {$fromsid} and ns.tosid = {$tosid} and ns.nstatus = 'unread' and ns.notificationtype = 'Tips' and ns.ntime = '{$timeinserted}';")->fetch_assoc();
                }
                $nid = $result['nid'];
                // $conn->query("insert into Tips values({$nid}, '{$text}', '{$timeinserted}');");
                $sendtip_protected = $conn->prepare("insert into Tips values(?,?,?);");
                $sendtip_protected->bind_param("iss", $nid, $text, $timeinserted);
                $sendtip_protected->execute();
                $affectedRows = $sendtip_protected->affected_rows;
                $sendtip_protected->close();
                if ($affectedRows >= 1) {
        ?>
                    <p>Tips sent</p>
        <?php
                } else {
        ?>
                    <p>Tips NOT sent</p>
        <?php
                }
            }
        ?>
        <a href="javascript:history.go(-2)">GO BACK</a>
    </body>
</html>
