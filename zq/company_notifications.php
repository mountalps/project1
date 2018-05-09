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
            <a href="company_jobs.php">Notifications</a> |
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
        <?php
        ?>
    <?php endif;?>
    

</div>

</body>
</html>
