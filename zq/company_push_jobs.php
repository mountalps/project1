<?php
    /**
     * Created by PhpStorm.
     * User: wesley
     * Date: 5/6/18
     * Time: 15:30
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
//    $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
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
    
    $cid = $companyInfo[0][0];
    $sqlGetAvailableJobInfo = "select * from Job where cid = '{$cid}' and expirationDate > now();";
    $sqlGetAvailableJobInfo = $conn_protect->prepare("select * from Job where cid = ? and expirationDate > now();");
    $sqlGetAvailableJobInfo->bind_param("i", $cid_protect);
    $cid_protect = $cid;
    $sqlGetAvailableJobInfo->execute();
    $resultAvailableJobInfo = $sqlGetAvailableJobInfo->get_result();
    $availableJobInfo = $resultAvailableJobInfo->fetch_all();
//    var_dump($availableJobInfo);
    
//    $resultAvailableJobInfo = mysqli_query($conToDB, $sqlGetAvailableJobInfo);
//    $availableJobInfo = mysqli_fetch_all($resultAvailableJobInfo, MYSQLI_ASSOC);
//    variant_round($availableJobInfo);

    
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
            <form action="company_search_result.php" method="get" id="keyword_search">
                <input type="text" placeholder="Search..." name="keyword">
                <button type="submit">search</button>
            </form>
        </div>
    </nav>
</div>

<div class="Push jobs">
    <h2>Please input your criteria</h2>
    <h3>If you don't have criteria in some attribute, please leave it blank</h3>
    <form action="company_push_jobs_result.php" method="post">
        <table>
            <tr>
                <td>University:</td>
                <td><input type="text" name="university" size="35"></td>
            </tr>
            <tr>
                <td>Major:</td>
                <td><input type="text" name="major" size="35"></td>
            </tr>
            <tr>
                <td>Degree:</td>
                <td><input type="text" name="degree" size="35"></td>
            </tr>
            <tr>
                <td>GPA:</td>
                <td><input type="text" name="GPA" size="35"></td>
            </tr>
            <tr>
                <td>Job ID</td>
                <td>
                    <select name="job_id" id="">
                        <?php foreach ($availableJobInfo as &$job): ?>
                            <?php echo "<option value='{$job[0]}'>{$job[0]}-{$job[1]}</option>"?>
                        <?php endforeach;?>
                    </select>
                    (only availabe jobs listed here)
                </td>
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
                <td align="right"><input type="submit" value="Push"></td>
            </tr>
        </table>
    
    
    </form>
    
</div>


</body>
</html>
