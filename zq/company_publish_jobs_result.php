<?php
    /**
     * Created by PhpStorm.
     * User: wesley
     * Date: 5/6/18
     * Time: 11:32
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
    
    $conn_protect = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase);
//    var_dump($conn_protect);
    
    $getCompanyInfo = $conn_protect->prepare("select * from Company where cusername = ?;");
//    var_dump($getCompanyInfo);
//    echo '__________';
    $getCompanyInfo->bind_param("s", $cusername_protect);
    $cusername_protect = $username;
    $getCompanyInfo->execute();
    $companyInfo = $getCompanyInfo->get_result();
    $companyInfo = $companyInfo->fetch_all();
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
    
    $job_title = htmlspecialchars($_POST['job-title']);
    $job_city = htmlspecialchars($_POST['job-city']);
    $job_state = htmlspecialchars($_POST['job-state']);
    $job_country = htmlspecialchars($_POST['job-country']);
    $job_salary = htmlspecialchars($_POST['job-salary']);
    $job_degree = htmlspecialchars($_POST['job-degree']);
    $job_major = htmlspecialchars($_POST['job-major']);
    $job_description = htmlspecialchars($_POST['job-description']);
    $job_expires = htmlspecialchars($_POST['job-expires']);
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
    
    $conn_protect1 = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase);//No error
//    var_dump($conn_protect1);
    $publishJob = $conn_protect1->prepare("insert into Job (jid, title, cid, jcity, jstate, jcountry, salary, degree, major, jdescription, expirationDate) values(?,?,?,?,?,?,?,?,?,?,?);");
//    var_dump($publishJob);
    
    $publishJob->bind_param("isisssdssss", $jid_protect, $title_protect, $cid_protect, $jcity_protect, $jstate_protect, $jcountry_protect, $salary_protect, $degree_protect, $major_protect, $jdescription_protect, $expirationDate_protect);
    $jid_protect = null;
    $title_protect = $job_title;
    $cid_protect = $companyInfo[0][0];
    $jcity_protect = $job_city;
    $jstate_protect = $job_state;
    $jcountry_protect = $job_country;
    $salary_protect = $job_salary;
    $degree_protect = $job_degree;
    $major_protect = $job_major;
    $jdescription_protect = $job_description;
    $expirationDate_protect = $job_expires;
    
//    var_dump($companyInfo[0][0]);
    $publishJob->execute();
    $affectedRows = $publishJob->affected_rows;
//    var_dump($affectedRows);
    if ($affectedRows >= 1)
        $resultPublishAJob = 'true';
    else
        $resultPublishAJob = 'false';
    
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

<?php if ($resultPublishAJob):?>
    <h2>Job Created Successfully!</h2>
    
<?php else:?>
    <h2>Job Created Unsuccessfully!</h2>
    <h2>Please Try Again!</h2>
    <button onclick="window.location.href='company_publish_jobs.php'">Try Again</button>

<?php endif;?>

</body>
</html>




