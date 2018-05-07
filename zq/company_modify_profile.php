<?php
/**
 * Created by PhpStorm.
 * User: wesley
 * Date: 5/5/18
 * Time: 23:06
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
    $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
    $sqlGetCompanyInfo = "select * from Company where cusername = '{$username}';";
    $resultCompanyInfo = mysqli_query($conToDB, $sqlGetCompanyInfo);
    $companyInfo = mysqli_fetch_all($resultCompanyInfo, MYSQLI_ASSOC);
//    var_dump($companyInfo);
    
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
            <a href="company_jobs.php">Your Jobs</a> |
            <a href="company_publish_jobs.php">Publish A Job</a> |
            <a href="company_push_jobs.php">Push A Job</a> |
            <a href="company_modify_profile.php">Modify Profile</a> |
            <a href="../lib/logout.php">Log Out</a> |
            <!--          <form action="company_search_result.php" method="get" id="keyword_search">-->
            <!--              <input type="text" placeholder="Search..." name="keyword">-->
            <!--              <button type="submit">search</button>-->
            <!--          </form>-->
        </div>
    </nav>
</div>
    

    <div class="modify_company_profile">
        <h1>Please input what you want to change</h1>
        <h4>If you don't want to change some profile, just leave it blank</h4>
        <form action="company_modify_profile_result.php" method="post">
            <table>
                <tr>
                    <td>New Password:</td>
                    <td><input type="password" name="cpassword" size="35"></td>
                </tr>
                <tr>
                    <td>Company Name:</td>
                    <td><input type="text" name = "cname"  size="35" placeholder="<?php echo $companyInfo[0]['cname'];?>"></td>
                </tr>
            
                <tr>
                    <td>city:</td>
                    <td><input type="text" name="ccity" size="35" placeholder="<?php echo $companyInfo[0]['ccity'];?>"></td>
                </tr>
            
                <tr>
                    <td>state:</td>
                    <td><input type="text" name="cstate" size="35" placeholder="<?php echo $companyInfo[0]['cstate'];?>"></td>
                </tr>
                <tr>
                    <td>country:</td>
                    <td><input type="text" name="ccountry" size="35" placeholder="<?php echo $companyInfo[0]['ccountry'];?>"></td>
                </tr>
                <tr>
                    <td>industry:</td>
                    <td><input type="text" name="industry" size="35" placeholder="<?php echo $companyInfo[0]['industry'];?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="right"><input type="submit" value="Change"></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
