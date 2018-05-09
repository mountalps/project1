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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notifications</title>
    <link rel="stylesheet" href="student.css">
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
        <?php
            // database connection
            session_start();
            $username = $_SESSION['user'];
            $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $testresult = $conn->query("select sid from Student where username = '{$username}';");
            if ($testresult->num_rows == 0) {
                header("Location: ../index.html");
                exit;
            }
            $q = $conn->query("SELECT sname, sid FROM Student s WHERE s.username = '{$username}';")->fetch_assoc();
            $sname = $q['sname'];
            $sid = $q['sid'];
            // the rest of the text
            $hellostr = "Helloha " . $sname . ",";
            echo "<h1>$hellostr</h1>";
        ?>
        <div>
            <h2>Here are your notifications:</h2>
        </div>
        <?php
            $queryfq = "select s2.sname, s.university, ns.nid, ns.fromsid from NotificationToStudent ns, Student s, Student s2 where ns.tosid = s.sid and ns.fromsid = s2.sid and s.username = '{$username}' and ns.nstatus = 'pending';";

            $queryf = "select ns.nstatus, ns.nid, ns.fromsid, j.jid, j.title, s.sname, j.jcity, j.jstate, j.jcountry from NotificationToStudent ns, Forward f, Job j, Student s, Student s2 where s.sid = ns.fromsid and s2.sid = ns.tosid and ns.nid = f.nid and f.jid = j.jid and s2.username = '{$username}';";

            $queryt = "select t.content, s.sname, t.ttime, ns.nstatus, ns.nid, ns.fromsid from NotificationToStudent ns, Tips t, Student s, Student s1 where t.nid = ns.nid and ns.fromsid = s.sid and ns.tosid=s1.sid and s1.username = '{$username}';";

            $resultfq = $conn->query($queryfq);
            $resultf = $conn->query($queryf);
            $resultt = $conn->query($queryt);
        ?>
        <ul>

            <li>
            <div class="pushed-jobs">
                <h3>Suggested Jobs:</h3>
                <?php
                    $resultpj = $conn->query("select ns.tosid, c.cname, ns.nid, p.jid, j.title, j.jcity, j.jstate, j.salary  from NotificationToStudent ns, Push p, Job j, Company c where ns.fromcid=c.cid and p.jid = j.jid and p.nid = ns.nid and ns.tosid = {$sid} and ns.notificationtype='Push' and ns.nstatus='unread';");
                    if ($resultpj->num_rows > 0) {
                        // echo "<p>Here are some friend requests:</p>";
                        while ($row = $resultpj->fetch_assoc()) {
                ?>
                            <div class="job">
                                <p><form class="job-info" action="job_info.php" method="post" id="job-info-form">
                                    <input type="hidden" name="nid" value="<?php echo $row['nid']; ?>">
                                    <input type="hidden" name="sid" value="<?php echo $sid; ?>">
                                    <button type="submit" name="jid" value="<?php echo $row['jid']; ?>"><?php echo $row['title']; ?></button>
                                     <?php echo "at {$row['jcity']}, {$row['jstate']} for {$row['salary']}. Company: {$row['cname']}"; ?>
                                </form></p>
                            </div>
                <?php
                        }
                    }
                ?>
            </div>
            </li>




            <li>
            <div class="friend-request">
                <h3>Friend Requests:</h3>
                <?php
                    if ($resultfq->num_rows > 0) {
                        // echo "<p>Here are some friend requests:</p>";
                        while ($row = $resultfq->fetch_assoc()) {
                            echo "<div class='friend-request-message' style='display:block; background-color:#e1e1e1;'><p>";
                            echo "You received a friend request from ";
                ?>
                            <form class="student-info" action="student_info.php" method="post" id="student-info-form">
                                <button type="submit" name="sid" value="<?php echo $row['fromsid']; ?>"><?php echo $row['sname']; ?></button>
                            </form>
                <?php
                            echo ", who is from ".$row['university'];
                            echo "</p>";
                ?>
                            <form class="fqdecision" action="handle_fq.php" method="post">
                                <button type="submit" name="frapprove" value="<?php echo $row['nid']; ?>">Approve <?php echo $row['sname']; ?></button>
                                <button type="submit" name="frreject" value="<?php echo $row['nid']; ?>">Reject <?php echo $row['sname'] ?></button>
                            </form>
                <?php
                            echo "</div>";
                        }
                    }
                ?>
            </div>
            </li>
            <li>
            <div class="forward">
                <h3>Forwared Jobs From Friend:</h3>
                <button onclick="myFunction1()" id="hide-forward-button-1">Hide clicked forwared jobs</button>
                <script type="text/javascript">
                    function myFunction1() {
                        var y = document.getElementById("hide-forward-button-1");
                        if (y.innerText === "Hide clicked forwared jobs") {
                            y.innerText = "Show clicked forwared jobs";
                        } else {
                            y.innerText = "Hide clicked forwared jobs";
                        }
                        for (let el of document.querySelectorAll('.forwarded-message-read')) {
                            if (el.style.display === "none") {
                                el.style.display = 'block';
                            } else {
                                el.style.display = 'none';
                            }

                        }
                    }
                </script>
                <?php
                    if ($resultf->num_rows > 0) {
                        // echo "<p>Here are some job forwards:</p>";
                        while ($row = $resultf->fetch_assoc()) {


                            if ($row['nstatus'] == 'read'){
                                echo "<div class='forwarded-message-read' style='background-color:#e1e1e1;display:block;'><p>";
                                echo "<div style='color:red;'>Your alread checked this job</div>";
                            } else {
                                echo "<div class='forwarded-message' style='background-color:#e1e1e1; display:block;'><p>";
                            }
                            echo "You received a job forward from ";
                    ?>
                                <form class="student-info" action="student_info.php" method="post" id="student-info-form">
                                    <button type="submit" name="sid" value="<?php echo $row['fromsid']; ?>"><?php echo $row['sname']; ?></button>
                                </form>
                    <?php
                            echo ", who forwared you the following job:<br>";
                            // echo $row['nid'];
                    ?>
                                <p><form class="job-info" action="job_info.php" method="post" id="job-info-form">
                                    <input type="hidden" name="sid" value="<?php echo $sid; ?>">
                                    <input type="hidden" name="nid" value="<?php echo $row['nid']; ?>">
                                    <button type="submit" name="jid" value="<?php echo $row['jid']; ?>"><?php echo $row['title']; ?></button>
                                     <?php echo "at {$row['jcity']}, {$row['jstate']}"; ?>
                                </form></p>
                    <?php
                            // echo ' in '.$row['jcity'].', '.$row['jstate'].', '.$row['jcountry'];
                            echo "</p></div>";
                        }
                    }
                ?>
            </div>
            </li>
            <li>
            <div class="tips">
                <h3>Student Messages:</h3>
                <h4>Unread Messages:</h4>
                <?php
                    $readtips = [];
                    if ($resultt->num_rows > 0) {
                        // echo "<p>Here are some messages(tips):</p>";
                        while ($row = $resultt->fetch_assoc()) {
                            if ($row['nstatus'] == 'unread') {
                                echo "<div class='unread-message'><p>";
                                echo "You received a message from ";
                ?>
                                <form class="student-info" action="student_info.php" method="post" id="student-info-form">
                                    <button type="submit" name="sid" value="<?php echo $row['fromsid']; ?>"><?php echo $row['sname']; ?></button>
                                </form>
                <?php
                                echo " on ".$row['ttime']."<br>";
                                echo $row['content'];
                                echo "</p></div>";
                ?>
                                <div class="tip-read-button">
                                    <form class="tip-read-form" action="handle-tip.php" method="post">
                                        <button type="submit" name="read-tip" value="<?php echo $row['nid']; ?>">mark the message from <?php echo $row['sname'] ?> as read</button>
                                    </form>
                                </div>
                                <div class="tip-delete-button">
                                    <form class="tip-delete-form" action="delete-tip.php" method="post">
                                        <button type="submit" name="delete-tip" value="<?php echo $row['nid']; ?>" onclick="return confirm('Are you sure you want to DELETE this message?')">DELETE the message from <?php echo $row['sname'] ?></button>
                                    </form>
                                </div>
                <?php
                            } else {
                                $readtips[] = $row;
                            }
                        }
                    } else {
                        echo "<p>You Don't have any tips from other student</p>";
                    }
                ?>
                <h4>Messages Already Read:</h4>
                <?php
                    if ($readtips != []) {
                        // echo "<p>You have some read tips:</p>";
                ?>
                        <button onclick="myFunction()" id="hide-button-1">Show read tips</button>
                        <script type="text/javascript">
                            function myFunction() {
                                var x = document.getElementById("read-tips");
                                var y = document.getElementById("hide-button-1");
                                if (x.style.display === "none") {
                                    x.style.display = "block";
                                    y.innerText = "Hide read tips";
                                } else {
                                    y.innerText = "Show read tips";
                                    x.style.display = "none";
                                }
                            }
                        </script>
                        <div id="read-tips" style="display:none;">
                            <?php
                                foreach ($readtips as $row) {
                                    echo "<div class='read-tip-area'><p>";
                                    echo "You read a message from ";
                            ?>
                                    <form class="student-info" action="student_info.php" method="post" id="student-info-form">
                                        <button type="submit" name="sid" value="<?php echo $row['fromsid']; ?>"><?php echo $row['sname']; ?></button>
                                    </form>
                            <?php
                                    echo " on ".$row['ttime']."<br>";
                                    echo $row['content'];
                                    echo "</p></div>";
                            ?>
                                    <div class="tip-unread-button">
                                        <form class="tip-read-form" action="handle-read-tip.php" method="post">
                                            <button type="submit" name="unread-tip" value="<?php echo $row['nid']; ?>">mark the message from <?php echo $row['sname'] ?> as unread</button>
                                        </form>
                                    </div>
                                    <div class="tip-delete-button">
                                        <form class="tip-delete-form" action="delete-tip.php" method="post">
                                            <button type="submit" name="delete-tip" value="<?php echo $row['nid']; ?>" onclick="return confirm('Are you sure you want to DELETE this message?')">DELETE the message from <?php echo $row['sname'] ?></button>
                                        </form>
                                    </div>
                            <?php
                                }
                            ?>
                        </div>
                <?php
                    } else {
                        echo "<p>You have no read tips</p>";
                    }
                ?>
        <?php
            $conn->close();
        ?>
            </div>
            </li>
        </ul>
        <?php
            // if ($result->num_rows > 0) {
            //     while ($row = $result->fetch_assoc()) {
            //         echo "<a href='#' class='job-a'>";
            //         echo "<div class='job-intro'>";
            //         echo "<div class='job-header'>
            //               <p>Job Title: ".$row["title"]."</p></div>";
            //         echo "<div class='job-company'>
            //               <p>By Company: ".$row["cname"]."</p></div>";
            //         echo "<div class='job-description'>
            //               <p>Description: ".$row["jdesciption"]."shlfdkjhasjkfhkjlasdhfajsdhlfjkashdfasdfaasjhdfkjlashdjkfahskdjf;akjsdhfjakshf;sdhfkjlashdfljkahsdfulawehfajksdhfnauwehfukasdfnajk.ehfajk.sdhfkjdkjhasjkfhkjlasdhfajsdhlfjkashdfasdfaasjhdfkjlashdjkfahskdjf;akjsdhfjakshf;sdhfkjlashdfljkahsdfulawehsdhfajsdhlfjkashdfasdfaasjhdfkjlashdjkfahskdjf;akjsdhfjakshf;sdhfkjlashdfljkahsdfulawehfajksdhfnauwehfukasdfnajk.ehfajk.sdhfkj.</p></div>";
            //         echo "<div class='job-location'>
            //               <p>Location: ".$row["jcity"].", ".$row["jstate"].", ".$row["jcountry"]."</p></div>";
            //         echo "<div class='job-major-degree'>".
            //               "<p>".$row["major"].", ".$row["degree"]."</p></div>";
            //         echo "<div class='job-salary'>
            //               <p>Salary: $ ".number_format($row["salary"])."</p></div>";
            //         echo "</div></a>";
            //     }
            // }
            // $conn->close();
        ?>
    </div>
</body>
</html>
