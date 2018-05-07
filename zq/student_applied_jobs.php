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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Applied Jobs</title>
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
      <div>
      <?php
      // database connection
      session_start();
      $username = $_SESSION['user'];
      $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
      $result = $conn->query("SELECT sname, sid FROM Student s WHERE s.username= '{$username}';")->fetch_assoc();
      $sname = $result['sname'];
      $sid = $result['sid'];

      // the rest of the text
      $hellostr = "Hello " . $sname . ",";
      echo "<h1>$hellostr</h1>";
      ?>
      </div>
      <div class="all-jobs">
          <h2>Applied Jobs:</h2>
          <?php
              $query = "
              select j.jid, j.title, j.jcity, j.jstate, j.jcountry, c.cname, c.cid, a.atime from Application a, Company c, Job j where a.tocid=c.cid and a.fromsid = ".$sid." and a.jid=j.jid;";
              $result = $conn->query($query);
              if ($result->num_rows > 0) {
                echo "<p>Here are your applied jobs:</p>";
                  while ($row = $result->fetch_assoc()) {
                    // echo "<div class='applied-job'><p>";
                    // echo $row['title'];
                    // echo " in ".$row['jcity'].", ".$row['jstate'].", ".$row['jcountry'];
                    // echo "on ".$row['atime'];
                    // echo "</p></div>";
            ?>
                    <div class="job">
                        <p><form class="job-info" action="job_info.php" method="post" id="job-info-form">
                            <input type="hidden" name="sid" value="<?php echo $sid; ?>">
                            <button type="submit" name="jid" value="<?php echo $row['jid']; ?>"><?php echo $row['title']; ?></button>
                             <?php echo "at {$row['jcity']}, {$row['jstate']} on {$row['atime']}"; ?>
                        </form></p>
                    </div>
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
