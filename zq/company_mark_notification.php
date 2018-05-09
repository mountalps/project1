<?php
    /**
     * Created by PhpStorm.
     * User: wesley
     * Date: 5/9/18
     * Time: 12:16
     */
    include_once '../lib/fun.php';
    include_once '../lib/dbinfo.php';
    
    $checkUser = checkLogin();
    //    var_dump($checkUser);
    if ($checkUser == "student"){
        header('Location: 0_student-homepage.php');
        exit;
    }
    
    session_start();
    $username = $_SESSION['user'];
    
    $atime = htmlspecialchars($_POST['atime']);
    $fromsid = htmlspecialchars($_POST['fromsid']);
    $jid = htmlspecialchars($_POST['jid']);
    
//    var_dump($atime);
//    var_dump($fromsid);
//    var_dump($jid);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jobster Company Home</title>
    <style>
        form {display: inline-block;}
        nav {background-color: #EEE}
        .wrapper {padding: 0 60px 0 60px;}
    </style>
</head>
<body>
<div class="navivation">
    <nav>
        <div class="wrapper">
            <a class="active" href="0_company-homepage.php">Home</a> |
            <a href="company_notifications.php">Notifications</a> |
            <a href="company_jobs.php">Your Jobs</a> |
            <a href="company_publish_jobs.php">Publish A Job</a> |
            <a href="company_push_jobs.php">Push A Job</a> |
            <a href="company_modify_profile.php">Modify Profile</a> |
            <a href="../lib/logout.php">Log Out</a> |
            <form action="company_search_result.php" method="get" id="keyword_search">
                <input type="text" placeholder="Search..." name="keyword">
                <button type="submit">search</button>
            </form>
        </div>
    </nav>
</div>

<div class="markread">
    <?php
        $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
        $sqlMarkRead = "UPDATE Application SET astatus = 'read' WHERE atime = '{$atime}' and fromsid = '{$fromsid}' and jid = '{$jid}';";
        $markRead = mysqli_query($conToDB, $sqlMarkRead);
        $markRead = mysqli_fetch_all($markRead, MYSQLI_ASSOC);
//        var_dump($markRead);
        header('Location:company_notifications.php');
    ?>
    
</div>

</body>
</html>
