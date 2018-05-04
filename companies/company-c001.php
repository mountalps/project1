<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
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
          <a class="active" href="../zq/0_company-homepage.php">Home</a> |
          <a href="../zq/company_notifications.php">Notifications</a> |
          <a href="../zq/company_jobs.php">Your Jobs</a> |
          <a href="../zq/company_publish_jobs.php">Publish A Job</a> |
          <form action="../zq/company_search_result.php" method="get" id="keyword_search">
              <input type="text" placeholder="Search..." name="keyword">
              <button type="submit">search</button>
          </form>
        </div>
      </nav>
    </div>
    <div class="wrapper">
      <div class="database-connection">
        <?php
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
      <div class="company-name">
        <?php
        $cid = 1;
        $query = "select cname FROM Company c WHERE c.cid =".$cid.";";
        $result = $conn->query($query);
        $cname = "";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cname = $row['cname'];
            }
        }
        // the rest of the text
        echo "<h2>$cname</h2>";?>
      </div>
      <div class="follow-button">
        <button type="submit" formaction="follow-company.php" name="follow-button">Follow</button>
      </div>
      <div class="published-jobs">
        <?php
          $cid = 1;
          $query = "
          SELECT j.title, j.jcity, j.jstate, j.jcountry, j.salary, c.cname, j.jdesciption, j.major, j.degree FROM Job j, Company c where j.cid = c.cid and c.cid = ".$cid.";";
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
            echo "<p>You have not published any jobs yet.</p>";
          }
          $conn->close();
        ?>
      </div>
    </div>
</body>
</html>
