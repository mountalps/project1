<?php
include_once '../lib/fun.php';
include_once '../lib/dbinfo.php';
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
            $query = "SELECT sname FROM Student s WHERE s.username = '{$username}';";
            $result = $conn->query($query);
            $sname = "";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $sname = $row['sname'];
                }
            }
            // the rest of the text
            $hellostr = "Helloha " . $sname . ",";
            echo "<h2>$hellostr</h2>";
        ?>
        <div>
            <p>Here are your notifications:</p>
        </div>
        <?php
            $queryfq = "select s2.sname, s.university, ns.nid, fq.fromsid from NotificationToStudent ns, FriendReq fq, Student s, Student s2 where ns.nid = fq.nid and fq.tosid = s.sid and fq.fromsid = s2.sid and s.username = '{$username}' and fq.fqstatus = 'pending';";

            $queryf = "select f.fromsid, j.jid, j.title, s.sname, j.jcity, j.jstate, j.jcountry, f.fromsid from NotificationToStudent ns, Forward f, Announcement a, Job j, Student s where s.sid = f.fromsid and ns.nid = f.fid and f.nid = a.nid and a.jid = j.jid;";

            $queryt = "select t.content, s.sname, t.ttime, ns.nstatus, ns.nid, ns.fromsid from NotificationToStudent ns, Tips t, Student s, Student s1 where t.nid = ns.nid and ns.fromsid = s.sid and ns.tosid=s1.sid and s1.username = '{$username}';";

            $resultfq = $conn->query($queryfq);
            $resultf = $conn->query($queryf);
            $resultt = $conn->query($queryt);
        ?>

            <div class="friend-request">
                <?php
                    if ($resultfq->num_rows > 0) {
                        echo "<br><br>Here are some friend requests:<br><br>";
                        while ($row = $resultfq->fetch_assoc()) {
                            echo "<div class='friend-request-message' style='display:block;'><p>";
                            echo "You received a friend request from ";
                ?>
                            <form class="student-info" action="student_info.php" method="post" id="student-info-form">
                                <button type="submit" name="sid" value="<?php echo $row['fromsid']; ?>"><?php echo $row['sname']; ?></button>
                            </form>
                <?php
                            echo ", who is from ".$row['university'];
                            echo "</p></div>";
                ?>
                            <form class="fqdecision" action="handle_fq.php" method="post">
                                <button type="submit" name="frapprove" value="<?php echo $row['nid']; ?>">Approve <?php echo $row['sname']; ?></button>
                                <button type="submit" name="frreject" value="<?php echo $row['nid']; ?>">Reject <?php echo $row['sname'] ?></button>
                            </form>
                <?php
                        }
                    }
                ?>
            </div>
            <div class="forward">
                <?php
                    if ($resultf->num_rows > 0) {
                        echo "<br><br>Here are some job forwards:<br><br>";
                        while ($row = $resultf->fetch_assoc()) {
                            echo "<div class='forwarded-message'><p>";
                            echo "You received a job forward from ";
                    ?>
                                <form class="student-info" action="student_info.php" method="post" id="student-info-form">
                                    <button type="submit" name="sid" value="<?php echo $row['fromsid']; ?>"><?php echo $row['sname']; ?></button>
                                </form>
                    <?php
                            echo ", who forwared you the following job:<br>";
                    ?>
                                <form class="job-info" action="job_info.php" method="post" id="job-info-form">
                                    <button type="submit" name="jid" value="<?php echo $row['jid']; ?>"><?php echo $row['title']; ?></button>
                                </form>
                    <?php
                            echo ' in '.$row['jcity'].', '.$row['jstate'].', '.$row['jcountry'];
                            echo "</p></div>";
                        }
                    }
                ?>
            </div>

            <div class="tips">
                <?php
                    $readtips = [];
                    if ($resultt->num_rows > 0) {
                        echo "<br><br>Here are some messages(tips):<br><br>";
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
                        echo "You Don't have no tips from other student";
                    }
                ?>
                <?php
                    if ($readtips != []) {
                        echo "<p>You have some read tips:</p>";
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
                                    echo "<div class='read-tip-area'>";
                                    echo "You read a message from ";
                            ?>
                                    <form class="student-info" action="student_info.php" method="post" id="student-info-form">
                                        <button type="submit" name="sid" value="<?php echo $row['fromsid']; ?>"><?php echo $row['sname']; ?></button>
                                    </form>
                            <?php
                                    echo " on ".$row['ttime']."<br>";
                                    echo $row['content'];
                                    echo "</div>";
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
