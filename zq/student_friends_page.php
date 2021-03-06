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
    <title>Friends</title>
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
            $query = "SELECT sname FROM Student s WHERE s.username = '{$username}'";
            $result = $conn->query($query);
            $sname = "";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $sname = $row['sname'];
                }
            }
            // the rest of the text
            $hellostr = "Hello " . $sname . ",";
            echo "<h1>$hellostr</h1>";
        ?>
        <div class="all-friends">
            <h2>Your Friends:</h2>
            <?php
                $query = "select s.sname, s.sid, s.university, s.major from ((select f.sid1 as sid from Friend f, Student s2 where f.sid2 = s2.sid and s2.username = '{$username}') union (select f.sid2 as sid from Friend f, Student s3 where f.sid1 = s3.sid and s3.username='{$username}')) a, Student s where s.sid = a.sid;";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    echo "<p>Here are your friends:</p>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='friend-info'><p>";
            ?>
                        <form class="student-info" action="student_info.php" method="post" id="student-info-form">
                            <button type="submit" name="sid" value="<?php echo $row['sid']; ?>"><?php echo $row['sname']; ?></button>
            <?php
                        echo " in ".$row['university'];
                        echo ", major in ".$row['major'];
            ?>
        </form></p></div>
            <?php
                    }
                } else {
                    echo "<p>You don't have any friends yet.</p>";
                }
                $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
