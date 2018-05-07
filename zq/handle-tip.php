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
    hi
    <?php
    session_start();
    $username = $_SESSION['user'];
    $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $nid = $_POST['read-tip'];
    echo $username;
    if ($conn->query("update NotificationToStudent ns, Student s set ns.nstatus='read' where ns.nid = {$nid} and ns.tosid=s.sid and s.username='{$username}';")) {
      echo "maked as read";
    } else {
      echo "something went wrong";
    }
    header("Location: student_notifications.php");
    exit;
    ?>
  </body>
</html>
