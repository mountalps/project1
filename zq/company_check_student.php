<?php
    /**
     * Created by PhpStorm.
     * User: wesley
     * Date: 5/6/18
     * Time: 14:03
     */
    
    include_once '../lib/fun.php';
    include_once '../lib/dbinfo.php';
    session_start();
    $username = $_SESSION['user'];
    $companyInfo = $_SESSION['companyInfo'];
    $sid = $_POST['sid'];
    
//    var_dump($companyInfo);
//    var_dump($sid);
    
    $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
    $sqlGetStudentInfo = "select * from Student where sid = '{$sid}';";
    $resultGetStudentInfo = mysqli_query($conToDB, $sqlGetStudentInfo);
    $studentInfo = mysqli_fetch_all($resultGetStudentInfo, MYSQLI_ASSOC);
//    var_dump($studentInfo[0]);
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

<div class="student display">
    <table border="1">
        <tr>
            <td>Name:</td>
            <td><?php echo "{$studentInfo[0]['sname']}";?></td>
        </tr>
        <tr>
            <td>University:</td>
            <td><?php echo "{$studentInfo[0]['university']}";?></td>
        </tr>
        <tr>
            <td>Major:</td>
            <td><?php echo "{$studentInfo[0]['major']}";?></td>
        </tr>
        <tr>
            <td>Degree:</td>
            <td><?php echo "{$studentInfo[0]['degree']}";?></td>
        </tr>
        <tr>
            <td>Keywords:</td>
            <td><?php echo "{$studentInfo[0]['keywords']}";?></td>
        </tr>
        <tr>
            <td>Resume:</td>
            <td></td>
        </tr>
    
    </table>

</div>

</body>
</html>
