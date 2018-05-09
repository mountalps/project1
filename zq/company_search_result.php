<?php
include_once '../lib/fun.php';
include_once '../lib/dbinfo.php';
$checkUser = checkLogin();
//    var_dump($checkUser);
if ($checkUser != "company"){
    header('Location: 0_student-homepage.php');
    exit;
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your Jobs</title>
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


<div class="wrapper">
    <div class="database-connection">
        <?php
            // database connection
            session_start();
            $username = $_SESSION['user'];
            $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $testresult = $conn->query("select cid from Company where cusername = '{$username}';");
            if ($testresult->num_rows == 0) {
                header("Location: ../index.html");
                exit;
            }
        ?>
    </div>
    <div class="say-hello-company">
        <?php
            $q = $conn->query("SELECT cname, cid FROM Company c WHERE c.cusername = '{$username}';")->fetch_assoc();
            $cname = $q['cname'];
            $cid = $q['cid'];
            $hellostr = "Hello " . $cname . ",";
            echo "<h1>$hellostr</h1>";
        ?>
    </div>
    <div class="search-keywords">
        <div class="query-prepare">
            <!-- can only search student, company, jobs -->
            <?php
                $keyword = htmlspecialchars($_GET["keyword"]);
                $pieces = explode(" ", $keyword);
                //echo count($pieces);
                $querylistsudent = [];
                $querylistjob = [];
                $querylistcompany = [];
                foreach($pieces as $k){
                    // $sqlConfirmNoDuplicate = $conn_protect->prepare("(select cid as num from Company where cusername = ?) union (select sid as num from Student where username=?);");
                    // $sqlConfirmNoDuplicate->bind_param("ss", $username_protect, $username_protect);
                    // $username_protect = $username;
                    // $sqlConfirmNoDuplicate->execute();
                    // $confirmResult = $sqlConfirmNoDuplicate->get_result();
                    // $confirmResult = $confirmResult->fetch_all();
                    // echo "here";

                    // student
                    $username_protect = "{$username}";
                    $keywords_protect = "%{$k}%";
                    if ($tempstudentprepare = $conn->prepare("select sid, sname from Student where username<>? and concat(sname, university, resume) like ? ;")) {
                        // $tempstudentprepare = $conn->prepare("select sid, sname from Student where username<>? and concat(sname, university) like ? ;");
                        $tempstudentprepare->bind_param("ss", $username_protect, $keywords_protect);
                        // $tempstudentprepare->execute();
                        $querylistsudent[] = $tempstudentprepare;
                    }
                    // $querylistsudent[] = "select sid, sname from Student where username <> '{$username}' and concat(sname, university) like '%".$k."%';";

                    // job
                    // $querylistjob[] = "select * from Job where concat(title, jcity, jstate, jcountry, jdescription) like '%".$k."%';";
                    if ($tempsjobprepare = $conn->prepare("select * from Job where concat(title, jcity, jstate, jcountry, jdescription) like ? ;")) {
                        // $tempstudentprepare = $conn->prepare("select sid, sname from Student where username<>? and concat(sname, university) like ? ;");
                        $tempsjobprepare->bind_param("s", $keywords_protect);
                        // $tempstudentprepare->execute();
                        $querylistjob[] = $tempsjobprepare;
                    }

                    // cpmpany
                    // $querylistcompany[] = "select cid, cname from Company where concat(cname, industry) like '%".$k."%';";
                    if ($tempscompanyprepare = $conn->prepare("select cid, cname from Company where concat(cname, industry) like ? ;")) {
                        // $tempstudentprepare = $conn->prepare("select sid, sname from Student where username<>? and concat(sname, university) like ? ;");
                        $tempscompanyprepare->bind_param("s", $keywords_protect);
                        // $tempstudentprepare->execute();
                        $querylistcompany[] = $tempscompanyprepare;
                    }
                }
            ?>
        </div>
    </div>
    <div class="get-search-result-student">
        <?php $student_query_result = []; ?>
        <div class="search-result-student">
            <?php
                foreach ($querylistsudent as $qstudent){
                    // echo $qstudent."<br>";
                    // $student_query_result[] = $conn->query($qstudent);
                    $qstudent->execute();
                    $student_query_result[] = $qstudent->get_result();
                    $qstudent->close();
                }
                // $student_query_result_unique = array_unique($student_query_result);
            ?>
        </div>
        <?php $job_query_result = []; ?>
        <div class="search-result-job">
            <?php
                foreach ($querylistjob as $qjob){
                    // echo $qjob."<br>";
                    // $job_query_result[] = $conn->query($qjob);
                    $qjob->execute();
                    $job_query_result[] = $qjob->get_result();
                    $qjob->close();
                }
                // $job_query_result_unique = array_unique($job_query_result);
            ?>
        </div>
        <?php $company_query_result = []; ?>
        <div class="search-result-company">
            <?php
                foreach ($querylistcompany as $qcompany){
                    // echo $qcompany."<br>";
                    // $company_query_result[] = $conn->query($qcompany);
                    $qcompany->execute();
                    $company_query_result[] = $qcompany->get_result();
                    $qcompany->close();
                }
                // $company_query_result_unique = array_unique($company_query_result);
            ?>
        </div>
    </div>
    <div class="display-search-result-student">
        <div class="display-student">
            <h2><p>Students according to your search:</p></h2>
            <?php
                $students = [];
                foreach ($student_query_result as $result) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $students[] = $row;
                        }
                    } else {
                        echo "<p>Sorry, we currently do not have any students.</p>";
                    }
                }
                $checkerstu = [];
                foreach ($students as $row) {
                    if (!in_array($row, $checkerstu)) {
                        ?>
                        <p><form class="student-info" action="company_check_student.php" method="post" id="student-info-form">
                            <button type="submit" name="sid" value="<?php echo $row['sid']; ?>"><?php echo $row['sname']; ?></button>
                        </form></p>
                        <?php
                        $checkerstu[] = $row;
                    }
                }
            ?>
        </div>
        <div class="display-job">
            <h2><p>Jobs according to your search:</p></h2>
            <?php
                $jobs = [];
                foreach ($job_query_result as $result) {
                    if ($result->num_rows > 0) {
                        // echo "entered if";
                        while ($row = $result->fetch_assoc()) {
                            $jobs[] = $row;
                        }
                    } else {
                        echo "<p>Sorry, we currentally do not have any avaliable jobs.</p>";
                    }
                }
                $checkerjob = [];
                foreach ($jobs as $row) {
                    if (!in_array($row,$checkerjob)){
                        ?>
                        <p><form class="job-info" action="job_info_for_company.php" method="post" id="job-info-form">
<!--                            <input type="hidden" name="sid" value="--><?php //echo $sid; ?><!--">-->
                            <button type="submit" name="jid" value="<?php echo $row['jid']; ?>"><?php echo $row['title']; ?></button>
                            <?php echo "at {$row['jcity']}, {$row['jstate']}"; ?>
                        </form></p>
                        <?php
                        $checkerjob[] = $row;
                    }
                    // echo $key."<br>";
                }
            ?>
        </div>
        <div class="display-company">
            <h2><p>Companies according to your search:</p></h2>
            <?php
                $companies = [];
                foreach ($company_query_result as $result) {
                    if ($result->num_rows > 0) {
                        // echo "entered if";
                        while ($row = $result->fetch_assoc()) {
                            $companies[] = $row;
                        }
                    } else {
                        echo "<p>Sorry, we currentally do not have any avaliable companies.</p>";
                    }
                }
                $checkercom = [];
                foreach (($companies) as $row) {
                    // echo $row[0];
                    if (!in_array($row, $checkercom)) {
                        ?>
                        <p><form class="company-info" action="company_info.php" method="post" id="company-info-form">
                            <button type="submit" name="cid" value="<?php echo $row['cid']; ?>"><?php echo $row['cname']; ?></button>
                        </form></p>
                        <?php
                        $checkercom[] = $row;
                    }
                }
            ?>
        </div>
    </div>
</div>
</body>
</html>
