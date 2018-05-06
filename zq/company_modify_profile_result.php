<?php
    /**
     * Created by PhpStorm.
     * User: wesley
     * Date: 5/6/18
     * Time: 10:31
     */
    include_once '../lib/fun.php';
    include_once '../lib/dbinfo.php';
    session_start();
    $username = $_SESSION['user'];
    
    $cpassword = $_POST['cpassword'];
    $cname = $_POST['cname'];
    $ccity = $_POST['ccity'];
    $cstate = $_POST['cstate'];
    $ccountry = $_POST['ccountry'];
    $industry = $_POST['industry'];
    
    var_dump($username);
    var_dump($cpassword);
    var_dump($cname);
    var_dump($ccity);
    var_dump($cstate);
    var_dump($ccountry);
    var_dump($industry);
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
            <a href="company_modify_profile.php">Modify Profile</a> |
            <form action="company_search_result.php" method="get" id="keyword_search">
                <input type="text" placeholder="Search..." name="keyword">
                <button type="submit">search</button>
            </form>
        </div>
    </nav>
</div>

<div class="wrapper">
    <?php
        $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
//        $cpassword = $_POST['cpassword'];
//        $cname = $_POST['cname'];
//        $ccity = $_POST['ccity'];
//        $cstate = $_POST['cstate'];
//        $ccountry = $_POST['ccountry'];
//        $industry = $_POST['industry'];
        
        if ($cpassword != ""){
            $cpassword = encryptPassword($cpassword);
            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $resultChangePassword = mysqli_query($conToDB, $sqlChangePassword);
            var_dump($resultChangePassword);
        }
    
        if ($cname != ""){
            
            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $resultChangePassword = mysqli_query($conToDB, $sqlChangePassword);
            var_dump($resultChangePassword);
        }
        
        
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>
</div>




</body>
</html>
