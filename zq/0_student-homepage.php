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
    <title>Jobster Home</title>
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
      $testresult = $conn->query("select sid from Student where username = '{$username}';");
      if ($testresult->num_rows == 0) {
          header("Location: ../index.html");
          exit;
      }
      $query = "SELECT sname FROM Student s WHERE s.username = '".$username."';";
      $result = $conn->query($query);
      $sname = "";
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $sname = $row['sname'];
          }
      }

      // the rest of the text
      $hellostr = "Hello " . $sname . ",";
      echo "<h2>$hellostr</h2>";
      ?>
      <?php
      $query = "SELECT j.title, j.jcity, j.jstate, j.jcountry, j.salary, c.cname, j.jdesciption, j.major, j.degree FROM Job j, Company c, Follow f, Student s where j.cid = c.cid and c.cid = f.cid and f.sid = s.sid and s.username ='{$username}';";
      $result = $conn->query($query);
      if ($result->num_rows > 0) {?>
        <div>
        Here are all jobs from companies you follow:<br>
        </div>
      <?php
          while ($row = $result->fetch_assoc()) {
              echo "<a href='#' class='job-a'>";
              echo "<div class='job-intro'>";
              echo "<div class='job-header'>
                    <p>Job Title: ".$row["title"]."</p></div>";
              echo "<div class='job-company'>
                    <p>By Company: ".$row["cname"]."</p></div>";
              echo "<div class='job-description'>
                    <p>Description: ".$row["jdesciption"]."shlfdkjhasjkfhkjlasdhfajsdhlfjkashdfasdfaasjhdfkjlashdjkfahskdjf;akjsdhfjakshf;sdhfkjlashdfljkahsdfulawehfajksdhfnauwehfukasdfnajk.ehfajk.sdhfkjdkjhasjkfhkjlasdhfajsdhlfjkashdfasdfaasjhdfkjlashdjkfahskdjf;akjsdhfjakshf;sdhfkjlashdfljkahsdfulawehsdhfajsdhlfjkashdfasdfaasjhdfkjlashdjkfahskdjf;akjsdhfjakshf;sdhfkjlashdfljkahsdfulawehfajksdhfnauwehfukasdfnajk.ehfajk.sdhfkj.</p></div>";
              echo "<div class='job-location'>
                    <p>Location: ".$row["jcity"].", ".$row["jstate"].", ".$row["jcountry"]."</p></div>";
              echo "<div class='job-major-degree'>".
                    "<p>".$row["major"].", ".$row["degree"]."</p></div>";
              echo "<div class='job-salary'>
                    <p>Salary: $ ".number_format($row["salary"])."</p></div>";
              echo "</div></a>";
          }
      }
      $conn->close();
      ?>
    </div>
</body>
</html>
