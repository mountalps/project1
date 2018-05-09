<?php
include_once '../lib/fun.php';
include_once '../lib/dbinfo.php';
$checkUser = checkLogin();
//    var_dump($checkUser);
if ($checkUser != "student"){
    header('Location: 0_company-homepage.php');
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
        $row = $conn->query("select j.title, j.cid, c.cname, j.jcity, j.jstate, j.jcountry, j.salary, j.degree, j.major, j.jdescription, j.expirationDate <= now() as expired From Job j, Company c where j.jid={$jid} and j.cid = c.cid;")->fetch_assoc();
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
        // var_dump($nid);
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
                <a href="student_modify_profile.php">Modify Profile</a> |
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
                <div class="job-company">
                    <h1>Company:
                        <form class="company-info" action="company_info.php" method="post">
                            <button type="submit" name="cid" value="<?php echo $cid; ?>"><?php echo $cname; ?></button>
                        </form>
                    </h1>
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
                    <?php
                        $result123 = $conn->query("select s.sname, s.sid from Student s, Friend f where (f.sid1={$sidpost} and s.sid = f.sid2) or (f.sid2={$sidpost} and s.sid=f.sid1) and s.sid not in (select ns.tosid from Forward f, NotificationToStudent ns where f.jid = {$jid} and ns.fromsid = {$sidpost});");
                        if ($result123->num_rows > 0) {
                    ?>
                            <div class="friend-forward-list" id="friend-forward-list-1" style="display:none;">
                                <form id="form" action="student-forward-to-friends.php" method="post">
                                    <div>
                                        <select name="forwardfriends[]" multiple="multiple" class="lstSelected">
                                            <!-- <option value="Batman">Batman</option> -->
                                            <?php
                                                while ($row123 = $result123->fetch_assoc()) {
                                                    echo "<option value=\"".$row123['sid']."\">".$row123['sname']."</option>";
                                                }
                                            ?>
                                        </select>
                                        <button type="submit" name="fromsid" value="<?php echo $sidpost; ?>">Forward this job to them</button>
                                        <input type="hidden" name="jid" value="<?php echo $jid; ?>">
                                    </div>
                                </form>
                                <p>Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.</p>
                            </div>
                    <?php } else {
                    ?>
                    <div class="friend-forward-list" id="friend-forward-list-1" style="display:none; background-color:#f1f1f1;">
                        <h3>You alread forward this job to all of your friends.</h3>
                    </div>
                <?php } ?>
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
