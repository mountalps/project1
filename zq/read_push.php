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
            $testresult = $conn->query("select sid from Student where username = '{$username}';");
            if ($testresult->num_rows == 0) {
                header("Location: ../index.html");
                exit;
            }
            $nid = $_POST['nid'];
            $sid = $_POST['sid'];
            $jid = $_POST['jid'];
            
        ?>
    </head>
    <body>

    </body>
</html>
