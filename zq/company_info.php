<?php
include_once '../lib/fun.php';
include_once '../lib/dbinfo.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
        <?php
            session_start();
            $username = $_SESSION['user'];
            $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $cid = $_POST['cid'];
            $sid = $conn->query("select sid from Student where username = '{$username}';")->fetch_assoc()['sid'];
            $result = $conn->query("select cid, cname, ccity, cstate, ccountry, industry from Company where cid = {$cid};")->fetch_assoc();
            $cname = $result['cname'];
            $cid = $result['cid'];
            $ccity = $result['ccity'];
            $cstate = $result['cstate'];
            $ccountry = $result['ccountry'];
            $industry = $result['industry'];
            $countc = $conn->query("select count(*) as countc from Follow f, Student s where s.username = '{$username}' and s.sid=f.sid and f.cid = {$cid};")->fetch_assoc()['countc'];
        ?>
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
            <div class="company-info">
                <div class="company-head">
                    <div class="company-name">
                        <h2>Company Name: <?php echo $cname ?></h2>
                    </div>
                    <?php if ($countc == 0) { ?>
                        <div class="company-follow">
                            <form class="company-follow" action="company_follow_handle.php" method="post">
                                <input type="hidden" name="username" value="<?php echo $username ?>">
                                <button type="submit" name="cid" value="<?php echo $cid; ?>">Follow this company</button>
                            </form>
                        </div>
                    <?php } else { ?>
                        <div class="company-unfollow">
                            <form class="company-unfollow" action="company_unfollow_handle.php" method="post">
                                <input type="hidden" name="username" value="<?php echo $username ?>">
                                <button type="submit" name="cid" value="<?php echo $cid; ?>" onclick="return confirm('Are you sure you want to unfollow this company?')">Unfollow this company</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>
                <div class="company-body">
                    <h2>Company Location: <?php echo "{$ccity}, {$cstate}, {$ccountry}" ?></h2>
                    <h2>Company Industry: <?php echo $industry ?></h2>
                </div>
            </div>
            <div class="company-job">
                <?php
                    $avaliable = $conn->query("select * from Job j where j.cid = {$cid} and j.expirationDate > now();");
                    $expired = $conn->query("select * from Job j where j.cid = {$cid} and j.expirationDate <= now();");
                ?>
                <h2>Company Published Jobs:</h2>
                <ul>
                    <li><div class="company-avaliable-job">
                        <h3>Company Avaliable Jobs:</h3>
                        <?php
                            if ($avaliable->num_rows > 0) {
                                while ($row = $avaliable->fetch_assoc()) {
                        ?>
                                    <div class="job">
                                        <p><form class="job-info" action="job_info.php" method="post" id="job-info-form">
                                            <input type="hidden" name="sid" value="<?php echo $sid; ?>">
                                            <button type="submit" name="jid" value="<?php echo $row['jid']; ?>"><?php echo $row['title']; ?></button>
                                             <?php echo "at {$row['jcity']}, {$row['jstate']}"; ?>
                                        </form></p>
                                    </div>
                        <?php
                                }
                            }
                        ?>
                    </div></li>
                    <li><div class="company-expired-job">
                        <h3>Company Explired Jobs</h3>
                        <?php
                            if ($expired->num_rows > 0) {
                                while ($row = $expired->fetch_assoc()) {
                        ?>
                                    <div class="job">
                                        <p><form class="job-info" action="job_info.php" method="post" id="job-info-form">
                                            <input type="hidden" name="sid" value="<?php echo $sid; ?>">
                                            <button type="submit" name="jid" value="<?php echo $row['jid']; ?>"><?php echo $row['title']; ?></button>
                                             <?php echo "at {$row['jcity']}, {$row['jstate']}"; ?>
                                        </form></p>
                                    </div>
                        <?php
                                }
                            }
                        ?>
                    </div></li>
                </ul>
            </div>
        </div>
    </body>
</html>
