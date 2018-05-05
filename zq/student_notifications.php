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
    <title>Notifications</title>
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

        $query = "SELECT sname FROM Student s WHERE s.username = '{$username}';";
        $result = $conn->query($query);
        $sname = "";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sname = $row['sname'];
            }
        }

        // the rest of the text
        $hellostr = "Helloha " . $sname . ",";
        echo "<h2>$hellostr</h2>";
      ?>
      <div>
      Here are your notifications:<br>
      </div>
      <?php
      $queryfq = "select s2.sname, s.university, ns.nid from NotificationToStudent ns, FriendReq fq, Student s, Student s2 where ns.nid = fq.nid and fq.tosid = s.sid and fq.fromsid = s2.sid and s.username = '{$username}' and fq.fqstatus = 'pending';";

      $queryf = "select f.fromsid, j.jid, j.title, s.sname, j.jcity, j.jstate, j.jcountry from NotificationToStudent ns, Forward f, Announcement a, Job j, Student s where s.sid = f.fromsid and ns.nid = f.fid and f.nid = a.nid and a.jid = j.jid;";

      $queryt = "select t.content, s.sname, t.ttime from NotificationToStudent ns,  Tips t, Student s where ns.nid = t.nid and t.fromsid = s.sid;";

      $resultfq = $conn->query($queryfq);
      $resultf = $conn->query($queryf);
      $resultt = $conn->query($queryt);
      ?>

      <div class="friend-request">
      <?php
      if ($resultfq->num_rows > 0) {
        echo "<br><br>Here are some friend requests:<br><br>";
          while ($row = $resultfq->fetch_assoc()) {
            echo "<div class='friend-request-message' style='display:block;'><p>";
            echo "You received a friend request from ".$row['sname'];
            echo ", who is from ".$row['university'];
            echo "</p></div>";
            ?>
            <form class="fqdecision" action="handle_fq.php" method="post">
              <button type="submit" name="frapprove" value="<?php echo $row['nid']; ?>">Approve <?php echo $row['sname']; ?></button>
              <button type="submit" name="frreject" value="<?php echo $row['nid']; ?>">Reject <?php echo $row['sname'] ?></button>
            </form>
            <?php
          }
      }
      $conn->close();
      ?>
      </div>
      <div class="forward">
      <?php
      if ($resultf->num_rows > 0) {
        echo "<br><br>Here are some job forwards:<br><br>";
          while ($row = $resultf->fetch_assoc()) {
            echo "<div class='forwarded-message'><p>";
            echo "You received a job forward from ".$row['sname'];
            echo ", who forwared you the following job:<br>";
            echo $row['title'].' in '.$row['jcity'].', '.$row['jstate'].', '.$row['jcountry'];
            echo "</p></div>";
          }
      }
      ?>
      </div>

      <div class="tips">
      <?php
      if ($resultt->num_rows > 0) {
        echo "<br><br>Here are some messages(tips):<br><br>";
          while ($row = $resultt->fetch_assoc()) {
            echo "<div class='forwarded-message'><p>";
            echo "You received a message from ".$row['sname'];
            echo " on ".$row['ttime']."<br>";
            echo $row['content'];
            echo "</p></div>";
          }
      }
      $conn->close();
      ?>
      </div>

      <?php
      // if ($result->num_rows > 0) {
      //     while ($row = $result->fetch_assoc()) {
      //         echo "<a href='#' class='job-a'>";
      //         echo "<div class='job-intro'>";
      //         echo "<div class='job-header'>
      //               <p>Job Title: ".$row["title"]."</p></div>";
      //         echo "<div class='job-company'>
      //               <p>By Company: ".$row["cname"]."</p></div>";
      //         echo "<div class='job-description'>
      //               <p>Description: ".$row["jdesciption"]."shlfdkjhasjkfhkjlasdhfajsdhlfjkashdfasdfaasjhdfkjlashdjkfahskdjf;akjsdhfjakshf;sdhfkjlashdfljkahsdfulawehfajksdhfnauwehfukasdfnajk.ehfajk.sdhfkjdkjhasjkfhkjlasdhfajsdhlfjkashdfasdfaasjhdfkjlashdjkfahskdjf;akjsdhfjakshf;sdhfkjlashdfljkahsdfulawehsdhfajsdhlfjkashdfasdfaasjhdfkjlashdjkfahskdjf;akjsdhfjakshf;sdhfkjlashdfljkahsdfulawehfajksdhfnauwehfukasdfnajk.ehfajk.sdhfkj.</p></div>";
      //         echo "<div class='job-location'>
      //               <p>Location: ".$row["jcity"].", ".$row["jstate"].", ".$row["jcountry"]."</p></div>";
      //         echo "<div class='job-major-degree'>".
      //               "<p>".$row["major"].", ".$row["degree"]."</p></div>";
      //         echo "<div class='job-salary'>
      //               <p>Salary: $ ".number_format($row["salary"])."</p></div>";
      //         echo "</div></a>";
      //     }
      // }
      // $conn->close();
      ?>
    </div>
</body>
</html>
