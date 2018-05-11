<?php
    /**
     * Created by PhpStorm.
     * User: wesley
     * Date: 5/6/18
     * Time: 14:03
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
    $companyInfo = $_SESSION['companyInfo'];
//    var_dump($companyInfo);
    $sid = $_POST['sid'];
    
//    var_dump($companyInfo);
//    var_dump($sid);
    
    $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
    $sqlGetStudentInfo = "select * from Student where sid = '{$sid}';";
    $resultGetStudentInfo = mysqli_query($conToDB, $sqlGetStudentInfo);
    $studentInfo = mysqli_fetch_all($resultGetStudentInfo, MYSQLI_ASSOC);
//    var_dump($studentInfo[0]['restrict']);
    $restrict = $studentInfo[0]['restrict'];
//    var_dump($studentInfo[0]);
    
    $sqlApplication = "select * from Application where fromsid = '{$sid}' and tocid = '{$companyInfo[0]['cid']}';";
    $resultApplication = mysqli_query($conToDB, $sqlApplication);
    $resultApplication = mysqli_fetch_all($resultApplication, MYSQLI_ASSOC);
//    var_dump($resultApplication);
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

<div class="student display">
    
    <?php if (count($resultApplication) != 0):?>
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
            <td>GPA:</td>
            <td><?php echo "{$studentInfo[0]['GPA']}";?></td>
        </tr>
        <tr>
            <td>Keywords:</td>
            <td><?php echo "{$studentInfo[0]['keywords']}";?></td>
        </tr>
        <tr>
            <td>Resume:</td>
            <td><?php echo "{$studentInfo[0]['resume']}";?></td>
        </tr>
    
    </table>
    
    
    <?php elseif ($restrict == '0'):?>
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
            <td>GPA:</td>
            <td><?php echo "{$studentInfo[0]['GPA']}";?></td>
        </tr>
        <tr>
            <td>Keywords:</td>
            <td><?php echo "{$studentInfo[0]['keywords']}";?></td>
        </tr>
        <tr>
            <td>Resume:</td>
            <td><?php echo "{$studentInfo[0]['resume']}";?></td>
        </tr>
    
    </table>
    <?php else:?>
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
<!--            <tr>-->
<!--                <td>GPA:</td>-->
<!--                <td>--><?php //echo "{$studentInfo[0]['GPA']}";?><!--</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>Keywords:</td>-->
<!--                <td>--><?php //echo "{$studentInfo[0]['keywords']}";?><!--</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>Resume:</td>-->
<!--                <td>--><?php //echo "{$studentInfo[0]['resume']}";?><!--</td>-->
<!--            </tr>-->
    
        </table>
    
    <?php endif; ?>
    

</div>

</body>
</html>
