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
        $sid = $_POST['sid'];
        // $sid = 10;
        $studentname = ($conn->query("select s.sname from Student s where s.sid = ".$sid.";"))->fetch_assoc()['sname'];
        $currentusersid = ($conn->query("select s.sid from Student s where s.username = '{$username}';"))->fetch_assoc()['sid']
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
        <?php $studentuniversity = ($conn->query("select s.university from Student s where s.sid = ".$sid.";"))->fetch_assoc()['university']; ?>
        <?php $studentmajor = ($conn->query("select s.major from Student s where s.sid = ".$sid.";"))->fetch_assoc()['major']; ?>
        <div class="public-student-info">
            <p>Name : <?php echo $studentname; ?></p>
            <p>University : <?php echo $studentuniversity; ?></p>
            <p>Major : <?php echo $studentmajor; ?></p>
        </div>
        <?php
            if ($currentusersid == $sid) {
                header("Location: 0_student-homepage.php");
                exit;
            }
            $torf = ($conn->query("select True as result from Friend f, Student s where s.username = '{$username}' and (s.sid = f.sid1 or s.sid = f.sid2) and (f.sid1 = {$sid} or f.sid2 = {$sid});"))->fetch_assoc()['result'];
            if ($torf == 1) {
                echo "they are friend";
        ?>
                <div class="private-student-info">
                    //TODO
                </div>
        <?php
            } else {
        ?>
        <?php
                $result = ($conn->query("select True as thereisfq, fq.nid, fq.fromsid, fq.tosid From FriendReq fq, Student s where fq.fqstatus='pending' and s.username = '{$username}' and (s.sid = fq.fromsid or s.sid = fq.tosid) and (fq.fromsid = {$sid} or fq.tosid = {$sid});"))->fetch_assoc();
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
                        <input type="hidden" name="fromusid" value="<?php echo $currentusersid; ?>">
                        <input type="hidden" name="tosid" value="<?php echo $sid; ?>">
                        <button type="submit" name="button">Send Friend Request to <?php echo $studentname; ?></button>
                    </form>
        <?php
                }
        ?>
        <?php
            }
        ?>
    </div>
</body>

</html>
