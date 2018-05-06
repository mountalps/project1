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
    
//    var_dump($username);
//    var_dump($cpassword);
//    var_dump($cname);
//    var_dump($ccity);
//    var_dump($cstate);
//    var_dump($ccountry);
//    var_dump($industry);
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
//            echo 'resultChangePassword:';
//            var_dump($resultChangePassword);
//            echo '<br>';
        }
    
        if ($cname != ""){
            
            $sqlChangeName = "update Company set cname='{$cname}' where cusername='{$username}';";
            $resultChangeName = mysqli_query($conToDB, $sqlChangeName);
//            echo 'resultChangeName:';
//            var_dump($resultChangeName);
//            echo '<br>';
    
        }
    
        if ($ccity != ""){
        
            $sqlChangeCity = "update Company set ccity='{$ccity}' where cusername='{$username}';";
            $resultChangeCity = mysqli_query($conToDB, $sqlChangeCity);
//            echo 'resultChangeCity:';
//            var_dump($resultChangeCity);
//            echo '<br>';
    
        }
    
    
        if ($cstate != ""){
        
            $sqlChangeState = "update Company set cstate='{$cstate}' where cusername='{$username}';";
            $resultChangeState = mysqli_query($conToDB, $sqlChangeState);
//            echo 'resultChangeState:';
//            var_dump($resultChangeState);
//            echo '<br>';
    
        }
    
        if ($ccountry != ""){
        
            $sqlChangeCountry = "update Company set ccountry='{$ccountry}' where cusername='{$username}';";
            $resultChangeCountry = mysqli_query($conToDB, $sqlChangeCountry);
//            echo 'resultChangeCountry:';
//            var_dump($resultChangeCountry);
//            echo '<br>';
    
        }
    
        if ($industry != ""){
        
            $sqlChangeIndustry = "update Company set industry='{$industry}' where cusername='{$username}';";
            $resultChangeIndustry = mysqli_query($conToDB, $sqlChangeIndustry);
//            echo 'resultChangeIndustry:';
//            var_dump($resultChangeIndustry);
//            echo '<br>';
    
        }
        ?>
</div>

<div class="changeResult" align="center">
    <h3>Here is your new profile</h3>
    <table>
        <tr>
            <td>Name: </td>
            <td><?php echo $cname?></td>
        </tr>
        <tr>
            <td>City: </td>
            <td><?php echo $ccity?></td>
        </tr>
        <tr>
            <td>State: </td>
            <td><?php echo $cstate?></td>
        </tr>
        <tr>
            <td>Country: </td>
            <td><?php echo $ccountry?></td>
        </tr>
        <tr>
            <td>Industry: </td>
            <td><?php echo $industry?></td>
        </tr>
    </table>
    
</div>




</body>
</html>
