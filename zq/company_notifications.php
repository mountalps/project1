<?php
    //This file can be deleted
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jobster Company Home</title>
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
            <a class="active" href="0_company-homepage.php">Home</a> |
            <a href="company_jobs.php">Your Jobs</a> |
            <a href="company_publish_jobs.php">Publish A Job</a> |
            <a href="company_push_jobs.php">Push A Job</a> |
            <a href="company_modify_profile.php">Modify Profile</a> |
            <a href="../lib/logout.php">Log Out</a> |
            <form action="company_search_result.php" method="get" id="keyword_search">
                <input type="text" placeholder="Search..." name="keyword">
                <button type="submit">search</button>
            </form>
        </div>
    </nav>
</div>
    <div class="wrapper">
      <div>
      <?php
      // get the sid from signin page
      $cid = $_SESSION['cid'];
      $cid = 1;

      // database connection
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $dbname = "PJ2database";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
      $query = "SELECT cname FROM Company c WHERE c.cid =".$cid.";";
      $result = $conn->query($query);
      $cname = "";
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $cname = $row['cname'];
          }
      }
      // the rest of the text
      $hellostr = "Hello " . $cname . ",";
      echo "<h2>$hellostr</h2>";
      ?>
      </div>
      <div class="company-notifications">
      <?php
      $query = "
      select j.title, j.jcity, j.jstate, j.jcountry, s.sname, s.university, s.major, s.degree from Application a, Job j, Student s where a.jid = j.jid and a.fromsid = s.sid and a.tocid = ".$cid.";";
      $result = $conn->query($query);
      if ($result->num_rows > 0) {
        echo "<br><br>Your company have the following applications:<br><br>";
          while ($row = $result->fetch_assoc()) {
            echo "<div class='company-application'><p>";
            echo "Student ".$row['sname']." from ".$row['university']." having ".$row['degree']. " in ".$row['major']. 'major';
            echo " try to apply the ".$row['title']. 'position in '.$row['jcity'].", ".$row['jstate'].", ".$row['jcountry'];
            echo "</p></div>";
          }
      } else {
        echo "<br><br>You have not published any jobs yet.<br><br>";
      }
      $conn->close();
      ?>
      </div>
    </div>
</body>
</html>
