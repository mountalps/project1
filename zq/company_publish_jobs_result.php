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
//    var_dump($companyInfo);
    
    
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
    $job_expires = $_POST['job-expires'];
    $job_expires = (int)$job_expires;
    
    date_default_timezone_set("America/New_York");
    $timeStamp = time();
    $time_now = date('Y-m-d H:i:s', $timeStamp);
    
    if ($job_expires == "1")
        $job_expires = date('Y-m-d H:i:s', strtotime("+1 months", strtotime($time_now)));
    elseif ($job_expires == "2")
        $job_expires = date('Y-m-d H:i:s', strtotime("+2 months", strtotime($time_now)));
    elseif ($job_expires == "3")
        $job_expires = date('Y-m-d H:i:s', strtotime("+3 months", strtotime($time_now)));
    elseif ($job_expires == "6")
        $job_expires = date('Y-m-d H:i:s', strtotime("+6 months", strtotime($time_now)));
    
    
//    var_dump($job_expires);
    
    
    //    var_dump($job_title);
//    var_dump($job_city);
//    var_dump($job_state);
//    var_dump($job_country);
//    var_dump($job_salary);
//    var_dump($job_degree);
//    var_dump($job_major);
//    var_dump($job_description);
    
//    if ($job_title == "" || $job_city == "" || $job_state == "" || $job_country == "" || $job_salary == "" || $job_degree == "" || $job_major == "" || $job_description == ""){
//        if ($job_title == "")
//            echo 'job title cannot be empty!<\br>';
//        if ($job_city == "")
//            echo 'job city cannot be empty!<\br>';
//        if ($job_state == "")
//            echo 'job state cannot be empty!<\br>';
//        if ($job_country == "")
//            echo 'job country cannot be empty!<\br>';
//        if ($job_salary== "")
//            echo 'job salary cannot be empty!<\br>';
//        if ($job_degree== "")
//            echo 'job degree cannot be empty!<\br>';
//        if ($job_major == "")
//            echo 'job major cannot be empty!<\br>';
//        if ($job_description == "")
//            echo 'job description cannot be empty!<\br>';
//    }
    
    $job_salary = (int)$job_salary;
//    var_dump($job_salary);
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
    
    $sqlPublishAJob = "insert into Job values
(null, '{$job_title}', '{$companyInfo[0]['cid']}', '{$job_city}', '{$job_state}', '{$job_country}', '{$job_salary}', '{$job_degree}', '{$job_major}', '{$job_description}', '{$job_expires}');";
    $resultPublishAJob = mysqli_query($conToDB, $sqlPublishAJob);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Publish a new job</title>
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

<?php if ($resultPublishAJob):?>
    <h2>Job Created Successfully!</h2>
    
<?php else:?>
    <h2>Job Created Unsuccessfully!</h2>
    <h2>Please Try Again!</h2>
    <button onclick="window.location.href='company_publish_jobs.php'">Try Again</button>

<?php endif;?>

</body>
</html>




