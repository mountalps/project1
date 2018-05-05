<?php
include_once '../lib/fun.php';
include_once '../lib/dbinfo.php';
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
      $row = ($conn->query("select fq.fromsid, fq.tosid from FriendReq fq, Student s where fq.nid = {$nid} and fq.tosid = s.sid and s.username = '{$username}';"))->fetch_assoc();
      $sid1 = $row['fromsid'];
      $sid2 = $row['tosid'];
      if ($conn->query("update NotificationToStudent ns, Student s set ns.nstatus = 'read' where ns.nid = {$nid} and ns.tosid = s.sid and s.username = '{$username}';")
          &&
          $conn->query("update FriendReq fq, Student s set fq.fqstatus = 'accepted' where fq.nid = {$nid} and fq.tosid = s.sid and s.username = '{$username}';")) {
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
      $row = ($conn->query("select fq.fromsid, fq.tosid from FriendReq fq, Student s where fq.nid = {$nid} and fq.tosid = s.sid and s.username = '{$username}';"))->fetch_assoc();
      $sid1 = $row['fromsid'];
      $sid2 = $row['tosid'];
      if ($conn->query("update NotificationToStudent ns, Student s set ns.nstatus = 'read' where ns.nid = {$nid} and ns.tosid = s.sid and s.username = '{$username}';")
          &&
          $conn->query("update FriendReq fq, Student s set fq.fqstatus = 'rejected' where fq.nid = {$nid} and fq.tosid = s.sid and s.username = '{$username}';")) {
            echo "rejected success";
          }

      echo $nid;
      echo "rejected";
      // echo $sid2;
    }
    header("Location: student_notifications.php");
    exit;
    ?>
  </body>
</html>
