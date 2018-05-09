<?php
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
    $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
    $sqlGetCompanyInfo = "select * from Company where cusername = '{$username}';";
    $resultCompanyInfo = mysqli_query($conToDB, $sqlGetCompanyInfo);
    $companyInfo = mysqli_fetch_all($resultCompanyInfo, MYSQLI_ASSOC);
    $_SESSION['companyInfo'] = $companyInfo;
    
    //    var_dump($companyInfo);
    
    $cid = $companyInfo[0]['cid'];
    $sqlGetAvailableJobInfo = "select * from Job where cid = '{$cid}' and expirationDate > now();";
    $resultAvailableJobInfo = mysqli_query($conToDB, $sqlGetAvailableJobInfo);
    $availableJobInfo = mysqli_fetch_all($resultAvailableJobInfo, MYSQLI_ASSOC);
    
    $sqlNewApplicationInfo = "select * from Application where tocid = '{$cid}' and astatus = 'unread';";
    $resultNewApplicationInfo = mysqli_query($conToDB, $sqlNewApplicationInfo);
    $newApplicationInfo = mysqli_fetch_all($resultNewApplicationInfo, MYSQLI_ASSOC);
    
    $sqlAllApplicationInfo = "select * from Application where tocid = '{$cid}' and astatus = 'read';";
    $resultAllApplicationInfo = mysqli_query($conToDB, $sqlAllApplicationInfo);
    $allApplicationInfo = mysqli_fetch_all($resultAllApplicationInfo, MYSQLI_ASSOC);
    var_dump($allApplicationInfo);
    
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

<div class="wrapper">
    <?php if (count($newApplicationInfo) == 0): ?>
        <h2 style="color:green">You have read all your notifications</h2>
    <?php endif;?>
</div>


<div class="notification display">
    
    <?php if (count($newApplicationInfo) != 0): ?>
        <?php foreach ($newApplicationInfo as &$newApplication): ?>
        <?php
//            var_dump($newApplication[0]);
            
            $stuid = $newApplication['fromsid'];
            $sqlStuInfo = "select * from Student where sid = '{$stuid}';";
            $resultStuInfo = mysqli_query($conToDB, $sqlStuInfo);
            $stuInfo = mysqli_fetch_all($resultStuInfo, MYSQLI_ASSOC);
//            var_dump($stuInfo);
            
            $jobid = $newApplication['jid'];
            $sqlGetJobInfo = "select * from Job where jid = '{$jobid}';";
            $resultGetJobInfo = mysqli_query($conToDB, $sqlGetJobInfo);
            $jobInfo = mysqli_fetch_all($resultGetJobInfo, MYSQLI_ASSOC);
//            var_dump($jobInfo);
        ?>
            <p>
            <form class="student-info" action="company_check_student.php" method="post" id="student-info-form">
                <button type="submit" name="sid" value="<?php echo $stuid; ?>"><?php echo $stuInfo[0]['sname']; ?></button> applies:
            </form>
            <form class="job-info" action="job_info_for_company.php" method="post" id="job-info-form">
                <button type="submit" name="jid" value="<?php echo $jobid; ?>"><?php echo $jobInfo[0]['title']; ?></button>
            </form>
        
            <form class="markread" action="company_mark_notification.php" method="post" id="mark">
                <input type="hidden"  name="atime" value="<?php echo $newApplication['atime']; ?>" >
                <input type="hidden"  name="fromsid" value="<?php echo $stuid; ?>" >
                <input type="hidden"  name="jid" value="<?php echo $jobid; ?>" >
                <input type="submit" name="markread" value="Mark as Read">
            </form>
            </p>
        <?php endforeach;?>
    <?php endif;?>
    
    
    <button onclick="myFunction2()" id="hide-push-button-1">Hide read notifications</button>
    <script type="text/javascript">
        function myFunction2() {
            var y = document.getElementById("hide-push-button-1");
            if (y.innerText === "Hide read notifications") {
                y.innerText = "Show read notifications";
            } else {
                y.innerText = "Hide read notifications";
            }
            for (let el of document.querySelectorAll('.push-message-read')) {
                if (el.style.display === "none") {
                    el.style.display = 'block';
                } else {
                    el.style.display = 'none';
                }
            }
        }
    </script>
    <?php if (count($allApplicationInfo) != 0): ?>
        <?php foreach ($allApplicationInfo as &$application): ?>
            <?php
//            var_dump($newApplication[0]);
            
            $stuid = $application['fromsid'];
            $sqlStuInfo = "select * from Student where sid = '{$stuid}';";
            $resultStuInfo = mysqli_query($conToDB, $sqlStuInfo);
            $stuInfo = mysqli_fetch_all($resultStuInfo, MYSQLI_ASSOC);
//            var_dump($stuInfo);
            
            $jobid = $application['jid'];
            $sqlGetJobInfo = "select * from Job where jid = '{$jobid}';";
            $resultGetJobInfo = mysqli_query($conToDB, $sqlGetJobInfo);
            $jobInfo = mysqli_fetch_all($resultGetJobInfo, MYSQLI_ASSOC);
//            var_dump($jobInfo);
            ?>
            <p>
            <form class="student-info" action="company_check_student.php" method="post" id="student-info-form">
                <button type="submit" name="sid" value="<?php echo $stuid; ?>"><?php echo $stuInfo[0]['sname']; ?></button> applies:
            </form>
            <form class="job-info" action="job_info_for_company.php" method="post" id="job-info-form">
                <button type="submit" name="jid" value="<?php echo $jobid; ?>"><?php echo $jobInfo[0]['title']; ?></button>
            </form>
            </p>
        <?php endforeach;?>
    <?php endif;?>
    

</div>

</body>
</html>
