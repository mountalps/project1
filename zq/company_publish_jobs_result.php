<?php
    /**
     * Created by PhpStorm.
     * User: wesley
     * Date: 5/6/18
     * Time: 11:32
     */
    include_once '../lib/fun.php';
    include_once '../lib/dbinfo.php';
    session_start();
    $username = $_SESSION['user'];
    $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
    $sqlGetCompanyInfo = "select * from Company where cusername = '{$username}';";
    $resultCompanyInfo = mysqli_query($conToDB, $sqlGetCompanyInfo);
    $companyInfo = mysqli_fetch_all($resultCompanyInfo, MYSQLI_ASSOC);
    
    
    //Job Table Attributes:
    //          `jid` INT NOT NULL auto_increment,
    //  `title` VARCHAR(100) NOT NULL,
    //  `cid` INT NOT NULL,
    //  `jcity` VARCHAR(20) NOT NULL,
    //  `jstate` VARCHAR(20) NOT NULL,
    //  `jcountry` VARCHAR(20) NOT NULL,
    //  `salary` MEDIUMINT NOT NULL,
    //  `degree` VARCHAR(20) NOT NULL,
    //  `major` VARCHAR(20) NOT NULL,
    //  `jdescription` TEXT NOT NULL,
    
    $job_title = $_POST['job-title'];
    $job_city = $_POST['job-city'];
    $job_state = $_POST['job-state'];
    $job_country = $_POST['job-country'];
    $job_salary = $_POST['job-salary'];
    $job_degree = $_POST['job-degree'];
    $job_major = $_POST['job-major'];
    $job_description = $_POST['job-description'];
    
//    var_dump($job_title);
//    var_dump($job_city);
//    var_dump($job_state);
//    var_dump($job_country);
//    var_dump($job_salary);
//    var_dump($job_degree);
//    var_dump($job_major);
//    var_dump($job_description);
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

</body>
</html>




