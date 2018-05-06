<?php
/**
 * Created by PhpStorm.
 * User: wesley
 * Date: 4/26/18
 * Time: 17:00
 */
include_once './lib/fun.php';
include_once './lib/dbinfo.php';

$sid = $_POST['sid'];
$username = $_POST['username'];
$password = $_POST['password'];
$sname = $_POST['sname'];
$university = $_POST['university'];
$major = $_POST['major'];
$degree = $_POST['degree'];
$GPA = $_POST['GPA'];
$keywords = $_POST['keywords'];
$resume = $_POST['resume'];
$restrict = $_POST['restrict'];
if ($restrict == 'yes'){
    $restrict = '1';
} else if ($restrict == "no" || $restrict == null){
    $restrict = '0';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Sign Up</title>
</head>
<body>

    <?php if($username == null || $password == null ||$sname == null):?>
    <?php if($username == null):?>
        <h1 >Please input your username!</h1>
    <?php endif;?>

    <?php if($password == null):?>
        <h1>Please input your password!</h1>
    <?php endif;?>

    <?php if($sname == null):?>
        <h1>Please input your name!</h1>
    <?php endif;?>
        <button onclick="window.location.href='index.html'">Return To Start Page</button>

    <?php else:?>

        <?php
            $password = encryptPassword($password);
            #student(sid, username, password, sname, university, degree, major, GPA, keywords, resume, restrict)
            $connect = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
            $sqlConfirmNoDuplicate = "(select cid as num from Company where cusername = '{$cusername}') union (select sid as num from Student where username='{$cusername}');";
            $resultConfirmNoDuplicate = mysqli_query($connect, $sqlConfirmNoDuplicate);
            $confirmResult = mysqli_fetch_all($resultConfirmNoDuplicate, MYSQLI_ASSOC);
        ?>

        <?php if(count($confirmResult)!=0):?>
            <h3>Your username has been occupied! Please sign up again</h3>
            <button onclick="window.location.href='index.html'">Return To Start Page</button>
        <?php else:?>
        <?php
        $sql = "insert into Student values
(null, '{$username}', '{$password}', '{$sname}', '{$university}', '{$major}', '{$degree}', '{$GPA}', '{$keywords}', '{$resume}', '{$restrict}');";
        $result = mysqli_query($connect, $sql);
        ?>

        <?php if ($result == 'true'):?>
            <h2>Sign Up Successfully!</h2>
            <button onclick="window.location.href='index.html'">Back to login</button>
            <?php

                session_start();
                $_SESSION['user'] = $username;
                header('Location:./zq/0_student-homepage.php');
                exit;
                ?>
        <?php else:?>
            <h2>Sign Up Unsuccessfully!</h2>

        <?php endif;?>

    <?php endif;?>
    <?php endif;?>


</body>
</html>
