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
            $testresult = $conn->query("select sid from Student where username = '{$username}';");
            if ($testresult->num_rows == 0) {
                header("Location: ../index.html");
                exit;
            }
            $sid = $_POST['sid'];
            // $sid = 10;
            $studentname = ($conn->query("select s.sname from Student s where s.sid = ".$sid.";"))->fetch_assoc()['sname'];
            $currentusersid = ($conn->query("select s.sid from Student s where s.username = '{$username}';"))->fetch_assoc()['sid'];
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
        <?php
            $result = ($conn->query("select s.university, s.major, s.degree, s.GPA, s.restrict, s.resume from Student s where s.sid = ".$sid.";"))->fetch_assoc();
            $studentuniversity = $result['university'];
            $studentmajor = $result['major'];
            $gpa = $result['GPA'];
            $degree = $result['degree'];
            $restrict = $result['restrict'];
            $resume = $result['resume'];
            // var_dump($resume);
        ?>

                <!-- <div class="public-student-info">
                    <table border="1 pix" width=50% style="margin:35px;">
                </table>
                </div> -->

        <?php
            // var_dump($sid);
            // var_dump($username);
            $torf = ($conn->query("select count(*) as coun from Friend f, Student s where s.username = '{$username}' and (s.sid = f.sid1 or s.sid = f.sid2) and (f.sid1 = {$sid} or f.sid2 = {$sid});"))->fetch_assoc()['coun'];
            // var_dump($torf);
            // var_dump($restrict);
            if ($restrict == "0" and $torf=='0'){
                // echo "hello";
        ?>
                <div class="private-student-info">
                    <table border="1 pix" width=50% style="margin:35px;">
                        <tr>
                            <td>Name</td>
                            <td><?php echo $studentname; ?></td>
                        </tr>
                        <tr>
                            <td>University</td>
                            <td><?php echo $studentuniversity; ?></td>
                        </tr>
                        <tr>
                            <td>Major</td>
                            <td><?php echo $studentmajor; ?></td>
                        </tr>
                        <tr>
                            <td>GPA</td>
                            <td><?php echo $gpa; ?></td>
                        </tr>
                        <tr>
                            <td>Degree</td>
                            <td><?php echo $degree; ?></td>
                        </tr>
                        <tr>
                            <td>Resume</td>
                            <td><?php echo $resume; ?></td>
                        </tr>
                    </table>
                </div>
        <?php
    }
    if  ($restrict == "1" and $torf=='0') {
            ?>
            <table border="1 pix" width=50% style="margin:35px;">
                <tr>
                    <td>Name</td>
                    <td><?php echo $studentname; ?></td>
                </tr>
                <tr>
                    <td>University</td>
                    <td><?php echo $studentuniversity; ?></td>
                </tr>
                <tr>
                    <td>Major</td>
                    <td><?php echo $studentmajor; ?></td>
                </tr>
            </table>
            <?php
        }
        ?>
        <?php
            if ($currentusersid == $sid) {
                header("Location: 0_student-homepage.php");
                exit;
            }

            if ($torf == '1') {
                // var_dump($torf);
                // if ($restrict == "1") {
        ?>
                    <!-- <div class="private-student-info">
                        <h2><p>GPA: <?php echo $gpa; ?></p></h2>
                        <h2><p>Degree: <?php echo $degree; ?></p></h2>
                        <h2><p>Resume: <?php echo $resume; ?></p></h2>
                    </div> -->
                    <div class="private-student-info">
                        <table border="1 pix" width=50% style="margin:35px;">
                            <tr>
                                <td>Name</td>
                                <td><?php echo $studentname; ?></td>
                            </tr>
                            <tr>
                                <td>University</td>
                                <td><?php echo $studentuniversity; ?></td>
                            </tr>
                            <tr>
                                <td>Major</td>
                                <td><?php echo $studentmajor; ?></td>
                            </tr>
                        <tr>
                            <td>GPA</td>
                            <td><?php echo $gpa; ?></td>
                        </tr>
                        <tr>
                            <td>Degree</td>
                            <td><?php echo $degree; ?></td>
                        </tr>
                        <tr>
                            <td>Resume</td>
                            <td><?php echo $resume; ?></td>
                        </tr>
                        </table>
                    </div>
        <?php
                // }
         ?>
                 <form class="remove-friend" action="remove-friend.php" method="post" id="remove-friend-form">
                     <input type="hidden" name="sid2" value="<?php echo $currentusersid; ?>">
                     <button type="submit" name="sid1" value="<?php echo $sid; ?>" onclick="return confirm('Are you sure you want to DELETE this message?')">DELETE friend <?php echo $row['sname']; ?></button>
                 </form>
                <div class="friend-message">
                    <p><br>You can send a message to your friend:</p>
                    <form class="tips-form" action="submit_tips.php" method="post">
                        <textarea name="tips-area" rows="8" cols="40" maxlength="200" placeholder="write some messages to your friend and click submit to send."></textarea>
                        <input type="hidden" name="fromsid" value="<?php echo $currentusersid; ?>">
                        <input type="hidden" name="tosid" value="<?php echo $sid; ?>">
                        <button type="submit">Submit</button>
                    </form>
                </div>
        <?php
            } else {
                $result = ($conn->query("select True as thereisfq, ns.nid, ns.fromsid, ns.tosid from NotificationToStudent ns, Student s where ns.nstatus='pending' and s.username = '{$username}' and (s.sid = ns.fromsid or s.sid = ns.tosid) and (ns.fromsid = {$sid} or ns.tosid = {$sid});"))->fetch_assoc();
                $thereisfq = $result['thereisfq'];
                $fromsid = $result['fromsid'];
                $tosid = $result['tosid'];
                $nid = $result['nid'];
                if ($thereisfq) {
                    if ($fromsid == $currentusersid) {
        ?>
                        <button type="button" name="button">Friend Requset Already Sent</button>
        <?php
                    } else {
                        echo "There is a friend reques from this person, and you can decide now:";
        ?>
                        <form class="fqdecision" action="handle_fq.php" method="post">
                            <button type="submit" name="frapprove" value="<?php echo $nid; ?>">Approve <?php echo $studentname; ?></button>
                            <button type="submit" name="frreject" value="<?php echo $nid; ?>">Reject <?php echo $studentname; ?></button>
                        </form>
        <?php
                    }
                } else {
                    echo "You are not friend, send a friend request to view more info about this student:";
        ?>
                    <form class="send_friend_request" action="send_friend_request.php" method="post">
                        <input type="hidden" name="fromsid" value="<?php echo $currentusersid; ?>">
                        <input type="hidden" name="tosid" value="<?php echo $sid; ?>">
                        <button type="submit" name="button">Send Friend Request to <?php echo $studentname; ?></button>
                    </form>
        <?php
                }
            }
        ?>
    </div>
</body>

</html>
