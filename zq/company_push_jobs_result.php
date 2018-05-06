<?php
    /**
     * Created by PhpStorm.
     * User: wesley
     * Date: 5/6/18
     * Time: 15:46
     */
    include_once '../lib/fun.php';
    include_once '../lib/dbinfo.php';
    
    session_start();
    $username = $_SESSION['user'];
    $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
    
    
    $sqlGetCompanyInfo = "select * from Company where cusername = '{$username}';";
    $resultCompanyInfo = mysqli_query($conToDB, $sqlGetCompanyInfo);
    $companyInfo = mysqli_fetch_all($resultCompanyInfo, MYSQLI_ASSOC);
    
    $university = $_POST['university'];
    $major = $_POST['major'];
    $degree = $_POST['degree'];
    $GPA = $_POST['GPA'];
    $job_id = $_POST['job_id'];
    
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
        
        $GPA = (int)$GPA;
        $GPA = ">="."'".$GPA."'";
    }
    
//    var_dump($university);
    $sqlGetStudentInfo = "select * from Student where university {$university} and major {$major} and GPA {$GPA};";
    $resultGetStudentInfo = mysqli_query($conToDB, $sqlGetStudentInfo);
    $studentInfo = mysqli_fetch_all($resultGetStudentInfo, MYSQLI_ASSOC);
//    var_dump($studentInfo[0]);
    

    
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
    <title>Title</title>
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
                $cid = $companyInfo[0]['cid'];
                $sid = $student['sid'];
            
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
//            var_dump($pushResult);
                $nid = $pushResult[0]['nid'];
//            var_dump($nid);
            
                $sqlPush = "insert into Push values
('{$nid}', '{$job_id}', '{$time_now}');";
                $push = mysqli_query($conToDB, $sqlPush);
                if ($push)
                    $pushNum += 1;
            
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
