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
    <title>Followed Companies</title>
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
      <div>
      <?php
      // database connection
      session_start();
      $username = $_SESSION['user'];
      $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
      $sname = ($conn->query("SELECT sname FROM Student s WHERE s.username = '{$username}';"))->fetch_assoc()['sname'];
      // the rest of the text
      $hellostr = "Hello " . $sname . ",";
      echo "<h1>$hellostr</h1>";
      ?>
      </div>
      <div class="all-companies">
          <h2>Followed Companies:</h2>
      <?php
      $result = $conn->query("select c.cid, c.cname, s.sid from Company c, Follow f, Student s where f.sid = s.sid and f.cid = c.cid and s.username = '{$username}';");
      if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
      ?>
                <div class='followed-companies'>
                    <p><form class="company-info" action="company_info.php" method="post" id="company-info-form">
                        <button type="submit" name="cid" value="<?php echo $row['cid']; ?>"><?php echo $row['cname']; ?></button>
                    </form></p>
                </div>
      <?php
            }
      } else {
            echo "<p>You don't have any followed companies yet.</p>";
      }
      $conn->close();
      ?>
      </div>
  </div>
</body>
</html>
