<?php
/**
 * Created by PhpStorm.
 * User: wesley
 * Date: 4/26/18
 * Time: 17:00
 */
include_once './lib/fun.php';
include_once './lib/dbinfo.php';

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);
$sname = htmlspecialchars($_POST['sname']);
$university = htmlspecialchars($_POST['university']);
$major = htmlspecialchars($_POST['major']);
$degree = htmlspecialchars($_POST['degree']);
$GPA = htmlspecialchars($_POST['GPA']);
$keywords = htmlspecialchars($_POST['keywords']);
$resume = htmlspecialchars($_POST['resume']);
$restrict = htmlspecialchars($_POST['restrict']);
//var_dump($resume);



if ($restrict == "yes"){
    $restrict = "1";
}
else if ($restrict == "no" || $restrict == null) {
    $restrict = "0";
}

//var_dump($restrict);

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
//            $connect = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
//            $sqlConfirmNoDuplicate = "(select cid as num from Company where cusername = '{$username}') union (select sid as num from Student where username='{$username}');";
//            $resultConfirmNoDuplicate = mysqli_query($connect, $sqlConfirmNoDuplicate);
//            $confirmResult = mysqli_fetch_all($resultConfirmNoDuplicate, MYSQLI_ASSOC);

        $conn_protect = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase);
        $sqlConfirmNoDuplicate = $conn_protect->prepare("(select cid as num from Company where cusername = ?) union (select sid as num from Student where username=?);");
        $sqlConfirmNoDuplicate->bind_param("ss", $username_protect, $username_protect);
        $username_protect = $username;
        $sqlConfirmNoDuplicate->execute();
        $confirmResult = $sqlConfirmNoDuplicate->get_result();
        $confirmResult = $confirmResult->fetch_all();
//            var_dump($confirmResult);
        ?>

        <?php if(count($confirmResult)!=0):?>
            <h3>Your username has been occupied! Please sign up again</h3>
            <button onclick="window.location.href='index.html'">Return To Start Page</button>
        <?php else:?>
        <?php
//            var_dump($restrict);
        $GPA = (int)$GPA;
//        var_dump($resume);
            $conn_protect = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase);
            $createStudentAccount = $conn_protect->prepare("insert into Student (sid, username, password, sname, university, major, degree, GPA, keywords, `resume`, `restrict`) values(?,?,?,?,?,?,?,?,?,?,?);");
            $createStudentAccount->bind_param("dssssssdsss", $sid_protect, $username_protect, $password_protect, $sname_protect, $university_protect, $major_protect, $degree_protect, $GPA_protect, $keywords_protect, $resume_protect, $restrict_protect);
            $sid_protect = null;
            $username_protect = $username;
            $password_protect = $password;
            $sname_protect = $sname;
            $university_protect = $university;
            $major_protect = $major;
            $degree_protect = $degree;
            $GPA_protect = $GPA;
            $keywords_protect = $keywords;
            $resume_protect = $resume;
            $restrict_protect = $restrict;
            $createStudentAccount->execute();
            $affectedRows = $createStudentAccount->affected_rows;
            if ($affectedRows >= 1)
                $result = 'true';
            else
                $result = 'false';

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
