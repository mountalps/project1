<?php
    /**
     * Created by PhpStorm.
     * User: wesley
     * Date: 5/6/18
     * Time: 15:46
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
    
//    $sqlGetCompanyInfo = "select * from Company where cusername = '{$username}';";
//    $resultCompanyInfo = mysqli_query($conToDB, $sqlGetCompanyInfo);
//    $companyInfo = mysqli_fetch_all($resultCompanyInfo, MYSQLI_ASSOC);
    
    $conn_protect = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase);
    //    var_dump($DBdatabase);
    $getCompanyInfo = $conn_protect->prepare("select * from Company where cusername = ?;");
    $getCompanyInfo->bind_param("s", $cusername_protect);
    $cusername_protect = $username;
    $getCompanyInfo->execute();
    $companyInfo = $getCompanyInfo->get_result();
    $companyInfo = $companyInfo->fetch_all();
    
    $university = htmlspecialchars($_POST['university']);
    $major = htmlspecialchars($_POST['major']);
    $degree = htmlspecialchars($_POST['degree']);
    $GPA = htmlspecialchars($_POST['GPA']);
    $job_id = htmlspecialchars($_POST['job_id']);
    
//    var_dump($university);
//    var_dump($major);
//    var_dump($degree);
//    var_dump($GPA);
//    var_dump($job_id);
    
    if ($university == ""){
        $university = "like '%%'";
    }
    else{
        $university = "="."'".$university."'";
    }
    
    if ($major == ""){
        $major = "like '%%'";
    }
    else{
        $major = "="."'".$major."'";
    }
    
    if ($degree == ""){
        $degree = "like '%%'";
    }
    else{
        $degree = "="."'".$degree."'";
    }
    
    if ($GPA == ""){
        $GPA = "like '%%'";
    }
    else{
        
        $GPA = (double)$GPA;
        $GPA = ">="."'".$GPA."'";
    }
    
//    var_dump($university);
    $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
    $sqlGetStudentInfo = "select * from Student where university {$university} and major {$major} and GPA {$GPA};";
    $resultGetStudentInfo = mysqli_query($conToDB, $sqlGetStudentInfo);
    $studentInfo = mysqli_fetch_all($resultGetStudentInfo, MYSQLI_ASSOC);
//    var_dump($studentInfo);
//    var_dump($studentInfo[0]);
    
    
//    $conn_protect = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase);
//    //    var_dump($DBdatabase);
//    $sqlGetStudentInfo = $conn_protect->prepare("select * from Student where university ? and major ? and GPA ?;");
//    var_dump($sqlGetStudentInfo);
//    $sqlGetStudentInfo->bind_param("ssd", $university_protect, $major_protect, $GPA_protect);
//    $university_protect = $university;
//    $major_protect = $major;
//    $GPA_protect = $GPA;
//
//    $sqlGetStudentInfo->execute();
//    $studentInfo = $sqlGetStudentInfo->get_result();
//    $studentInfo = $studentInfo->fetch_all();
//    var_dump($studentInfo);
    
//    `NotificationToStudent` (
//`nid` INT NOT NULL auto_increment,
//  `fromsid` INT,
//  `fromcid` INT,
//  `tosid` INT NOT NULL,
//  `nstatus` VARCHAR(20) NOT NULL,
//  `ntime` datetime not null,
//  `notificationtype` VARCHAR(20) NOT NULL,


    
    
    
    
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
<div class="push">
    <?php
        if ($studentInfo[0] == null){
            echo 'No Students Satisfy your criteria! Please Try Again!';
        }
        else{
        
            $studentNum = count($studentInfo);
            $pushNum = 0;
            foreach ($studentInfo as $student){
                $cid = $companyInfo[0][0];
//                var_dump($cid);
                $sid = $student['sid'];
//                var_dump($sid);
            
                date_default_timezone_set("America/New_York");
                $timeStamp = time();
                $time_now = date('Y-m-d H:i:s', $timeStamp);
            
                $sqlCreatePush = "insert into NotificationToStudent values
(null, null, '{$cid}', '{$sid}','unread', '{$time_now}', 'Push');";
                $pushResult = mysqli_query($conToDB, $sqlCreatePush);
//            var_dump($pushResult);
            
                $sqlGetNID = "select * from NotificationToStudent where fromcid ='{$cid}' and tosid = '{$sid}' and ntime = '{$time_now}';";
                $pushResult = mysqli_query($conToDB, $sqlGetNID);
                $pushResult = mysqli_fetch_all($pushResult, MYSQLI_ASSOC);
//                var_dump($pushResult);
//            var_dump($pushResult);
                $nid = $pushResult[0]['nid'];
//            var_dump($nid);
            
                $sqlPush = "insert into Push values
('{$nid}', '{$job_id}', '{$time_now}');";
                $push = mysqli_query($conToDB, $sqlPush);
//                var_dump($push);
                if ($push)
                    $pushNum += 1;
//                var_dump($pushNum);
            
            }
        
            if ($pushNum == $studentNum){
                echo "<h2>You successfully push your job to {$studentNum} students!</h2>";
            }
            else{
            
                $failnum = $studentNum - $pushNum;
                echo "<h2>{$failnum} push failed, please try again</h2>";
            }
        }
    ?>
</div>


</body>
</html>
