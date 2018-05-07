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
        <title>handle fq</title>
    </head>
    <body>
        <?php
            session_start();
            $username = $_SESSION['user'];
            $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            if (trim($_POST['frapprove']) != "") {
                $nid = $_POST['frapprove'];
                $row = ($conn->query("select ns.fromsid, ns.tosid from NotificationToStudent ns, Student s where ns.nid = {$nid} and ns.tosid = s.sid and s.username = '{$username}';"))->fetch_assoc();
                $sid1 = $row['fromsid'];
                $sid2 = $row['tosid'];
                if ($conn->query("update NotificationToStudent ns, Student s set ns.nstatus = 'approved' where ns.nid = {$nid} and ns.tosid = s.sid and s.username = '{$username}';")) {
                    if ($sid1 > $sid2) {
                        $conn->query("insert into Friend values({$sid2},{$sid1});");
                    } else if ($sid2 > $sid1) {
                        $conn->query("insert into Friend values({$sid1},{$sid2});");
                    }
                }
                echo $nid;
                // echo $sid1;
            } else if (trim($_POST['frreject']) != "") {
                $nid = $_POST['frreject'];
                $row = ($conn->query("select ns.fromsid, ns.tosid from NotificationToStudent ns, Student s where ns.nid = {$nid} and ns.tosid = s.sid and s.username = '{$username}';"))->fetch_assoc();
                $sid1 = $row['fromsid'];
                $sid2 = $row['tosid'];
                if ($conn->query("update NotificationToStudent ns, Student s set ns.nstatus = 'rejected' where ns.nid = {$nid} and ns.tosid = s.sid and s.username = '{$username}';")) {
                    echo "rejected success";
                }
                echo $nid;
                echo "rejected";
                // echo $sid2;
            }
            header("Location: student_friends_page.php");
            exit;
        ?>
    </body>
</html>
