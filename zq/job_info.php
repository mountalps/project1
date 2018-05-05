<?php
include_once '../lib/fun.php';
include_once '../lib/dbinfo.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <?php
        session_start();
        $username = $_SESSION['user'];
        $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $jid = $_POST['jid'];
        $row = $conn->query("select title, cid, jcity, jstate, jcountry, salary, degree, major, jdescription From Job where jid={$jid};")->fetch_assoc();
        // $title = $row['title'];
        // $jcity = $row['jcity'];
        // $jstate = $row['jstate'];
        // $jmajor = $row['major'];
        // $jdegree = $row['degree'];
        // $jsalary = $row['salary'];
        // $jcountry = $row['jcountry'];
        // $jdescription = $row['jdesciption'];
        //
        // $cid = $row['cid'];
        // $cname = $row['cname'];
    ?>
    <title><?php echo $studentname; ?></title>
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
                <a class="active" href="0_student-homepage.php">Home</a> |
                <a href="student_notifications.php">Notifications</a> |
                <a href="student_friends_page.php">Friends</a> |
                <a href="student_followed_companies.php">Followed Companies</a> |
                <a href="student_applied_jobs.php">Applied Jobs</a> |
                <form action="student_search_result.php" method="get" id="keyword_search">
                    <input type="text" placeholder="Search..." name="keyword">
                    <button type="submit">search</button>
                </form>
            </div>
        </nav>
    </div>
    <div class="wrapper">
    </div>
</body>

</html>
