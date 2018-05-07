<?php
include_once '../lib/fun.php';
include_once '../lib/dbinfo.php';
$checkUser = checkLogin();
//    var_dump($checkUser);
if ($checkUser != "student"){
    header('Location: 0_student-homepage.php');
    exit;
}
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
        $sidpost = $_POST['sid'];
        $usersid = $conn->query("select sid from Student where username = '{$username}';")->fetch_assoc()['sid'];
        $row = $conn->query("select title, cid, jcity, jstate, jcountry, salary, degree, major, jdescription, expirationDate <= now() as expired From Job where jid={$jid};")->fetch_assoc();
        $title = $row['title'];
        $jcity = $row['jcity'];
        $jstate = $row['jstate'];
        $jmajor = $row['major'];
        $jdegree = $row['degree'];
        $jsalary = $row['salary'];
        $jcountry = $row['jcountry'];
        $jdescription = $row['jdescription'];
        $cid = $row['cid'];
        $cname = $row['cname'];
        $expired = $row['expired'];
        $nid = $_POST['nid'];
        if ($nid!="") {
            $conn->query("update NotificationToStudent set nstatus='read' where nid={$nid};");
        }
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
                <a href="../lib/logout.php">Log Out</a> |
                <form action="student_search_result.php" method="get" id="keyword_search">
                    <input type="text" placeholder="Search..." name="keyword">
                    <button type="submit">search</button>
                </form>
            </div>
        </nav>
    </div>
    <div class="wrapper">
        <div class="job-info">
            <div class="job-head">
                <div class="job-title">
                    <h1><?php echo $title; ?></h1>
                </div>
                <div class="job-apply">
                    <?php
                    // echo $usersid;
                    // echo $sidpost;
                    // $usersid = $conn->query("select sid from Student where username = '{$username}';")->fetch_assoc()['sid'];
                    if ($usersid != $sidpost) {
                        header("Location: ../index.html");
                        exit;
                    }
                    // echo $jid." and ".$sidpost." and ".$usersid;
                    $countj = ($conn->query("select count(*) as countj from Application where fromsid = {$usersid} and jid = {$jid};"))->fetch_assoc()['countj'];
                    if ($countj == 0 && $expired == 0) {
                    ?>
                        <form class="job-apply" action="job-apply.php" method="post">
                            <input type="hidden" name="sid" value="<?php echo $sidpost; ?>">
                            <input type="hidden" name="cid" value="<?php echo $cid; ?>">
                            <button type="submit" name="jid" value="<?php echo $jid; ?>">Apply this job</button>
                        </form>
                    <?php } else  if ($countj > 0){?>
                        <button type="button" name="button">You Already Applied this job</button>
                    <?php } else{
                        echo "<button type='button' name='button'>This job expired</button>";
                    }?>
                </div>
                <div class="job-forward">
                    <button onclick="myFunction()" id="hide-forward-button-1">Forward this job to your friends</button>
                    <script type="text/javascript">
                        function myFunction() {
                            var x = document.getElementById("friend-forward-list-1");
                            var y = document.getElementById("hide-forward-button-1");
                            if (x.style.display === "none") {
                                x.style.display = "block";
                                y.innerText = "[hide] Forward this job to your friends";
                            } else {
                                y.innerText = "Forward this job to your friends";
                                x.style.display = "none";
                            }
                        }
                    </script>
                    <div class="friend-forward-list" id="friend-forward-list-1" style="display:none;">
                        <form id="form" action="" method="post">
                            <div>
                                <select id="inscompSelected" multiple="multiple" class="lstSelected">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                <input type="submit" value="submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="job-body">
                <h2>Job Location: <?php echo "{$jcity}, {$jstate}, {$jcountry}"; ?></h2>
                <h2>Job Salary: <?php echo "{$jsalary}"; ?></h2>
                <h2>Job Location: <?php echo "{$jcity}, {$jstate}, {$jcountry}"; ?></h2>
                <h2>Job Major Prefered: <?php echo "{$jmajor}"; ?></h2>
                <h2>Job Degree Prifered: <?php echo "{$jdegree}"; ?></h2>
                <div class="job-description" style="width:50%;">
                    <h2>Job Description:</h2>
                    <p><?php echo $jdescription; ?></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
