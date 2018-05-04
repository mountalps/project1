<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Job Created</title>
    <link rel="stylesheet" href="student.css">
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
      <div class="database-connection">
        <?php
          // get the username of student
          $sid = $_SESSION['studentid'];
          $sid = 1;

          // database connection
          $servername = "localhost";
          $username = "root";
          $password = "root";
          $dbname = "PJ2database";
          $conn = new mysqli($servername, $username, $password, $dbname);
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }
        ?>
      </div>
      <div class="say-hello-company">
        <?php
        $cid = 1;
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
        echo "<h2>$hellostr</h2>";?>
      </div>
      <div class="assign-values">
        <?php
          $job_title = $_POST["job-title"];
          $job_city = $_POST["job-city"];
          $job_state = $_POST["job-state"];
          $job_country = $_POST["job-country"];
          $job_salary = $_POST["job-salary"];
          $job_degree = $_POST["job-degree"];
          $job_major = $_POST["job-major"];
          $job_description = $_POST["job-description"];
         ?>
      </div>
      <div class="published-jobs">
        <?php
          $cid = 1;
          $query = "";
          $result = $conn->query($query);
          if ($result->num_rows > 0) {
            echo "<p>Here are published jobs of your company:</p>";
              while ($row = $result->fetch_assoc()) {
                echo "<div class='company-job'><p>";
                echo $row['title'];
                echo " in ".$row['jcity'].", ".$row['jstate'].", ".$row['jcountry'];
                echo ", looking for students have ".$row['degree']." degree in ".$row['major'];
                echo "</p></div>";
              }
          } else {
            echo "<p>Sorry, Job Creation Failed.</p>";
          }
          $conn->close();
        ?>
      </div>
    </div>
  </body>
</html>
