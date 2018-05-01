<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your Jobs</title>
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
            <a href="company_notifications.php">Notifications</a> |
            <a href="company_jobs.php">Your Jobs</a> |
            <a href="company_publish_jobs.php">Publish A Job</a> |
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
      <div class="published-jobs">
      <?php
      $query = "
      SELECT j.title, j.jcity, j.jstate, j.jcountry, j.salary, c.cname, j.jdesciption, j.major, j.degree FROM Job j, Company c where j.cid = c.cid and c.cid = ".$cid.";";
      $result = $conn->query($query);
      if ($result->num_rows > 0) {
        echo "<br><br>Here are published jobs of your company:<br><br>";
          while ($row = $result->fetch_assoc()) {
            echo "<div class='company-job'><p>";
            echo $row['title'];
            echo " in ".$row['jcity'].", ".$row['jstate'].", ".$row['jcountry'];
            echo ", looking for students have ".$row['degree']." degree in ".$row['major'];
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
