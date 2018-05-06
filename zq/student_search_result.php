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
    <title>Search Result</title>
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
        <div class="database-connection">
            <?php
                // database connection
                session_start();
                $username = $_SESSION['user'];
                $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
            ?>
        </div>
        <div class="say-hello-student">
            <?php
                $sname = $conn->query("select sname from Student s WHERE s.username = '{$username}'")->fetch_assoc()['sname'];
                $hellostr = "Hello " . $sname . ",";
                echo "<h2>$hellostr</h2>";
            ?>
        </div>
        <div class="search-keywords">
            <div class="query-prepare">
                <!-- can only search student, company, jobs -->
                <?php
                    $keyword = $_GET["keyword"];
                    $pieces = explode(" ", $keyword);
                    //echo count($pieces);
                    $querylistsudent = [];
                    $querylistjob = [];
                    $querylistcompany = [];
                    foreach($pieces as $k){
                        //echo "$k<br>";
                        $querylistsudent[] = "select sid, sname from Student where username <> '{$username}' and concat(sname, university) like '%".$k."%';";
                        $querylistjob[] = "select * from Job where concat(title, jcity, jstate, jcountry, jdescription) like '%".$k."%';";
                        $querylistcompany[] = "select cid, cname from Company where concat(cname, industry) like '%".$k."%';";
                    }
                ?>
            </div>
        </div>
        <div class="get-search-result-student">
            <?php $student_query_result = []; ?>
            <div class="search-result-student">
                <?php
                    foreach ($querylistsudent as $qstudent){
                        // echo $qstudent."<br>";
                        $student_query_result[] = $conn->query($qstudent);
                    }
                    // $student_query_result_unique = array_unique($student_query_result);
                ?>
            </div>
            <?php $job_query_result = []; ?>
            <div class="search-result-job">
                <?php
                    foreach ($querylistjob as $qjob){
                        // echo $qjob."<br>";
                        $job_query_result[] = $conn->query($qjob);
                    }
                    // $job_query_result_unique = array_unique($job_query_result);
                ?>
            </div>
            <?php $company_query_result = []; ?>
            <div class="search-result-company">
                <?php
                    foreach ($querylistcompany as $qcompany){
                        // echo $qcompany."<br>";
                        $company_query_result[] = $conn->query($qcompany);
                    }
                    // $company_query_result_unique = array_unique($company_query_result);
                ?>
            </div>
        </div>
        <div class="display-search-result-student">
            <div class="display-student">
                <?php
                    $students = [];
                    foreach ($student_query_result as $result) {
                      if ($result->num_rows > 0) {
                          echo "<p>Students accoring to your search:</p>";
                          while ($row = $result->fetch_assoc()) {
                              $students[] = $row["sname"];
                  ?>
                              <p><form class="student-info" action="student_info.php" method="post" id="student-info-form">
                                  <button type="submit" name="sid" value="<?php echo $row['sid']; ?>"><?php echo $row['sname']; ?></button>
                              </form></p>
                  <?php
                          }
                      } else {
                          echo "<p>Sorry, we currentally do not have any students.</p>";
                      }
                    }
                    // foreach (array_unique($students) as $key) {
                    //     echo $key."<br>";
                    // }
                ?>
            </div>
            <div class="display-job">
                <?php
                    $students = [];
                    foreach ($job_query_result as $result) {
                        if ($result->num_rows > 0) {
                            echo "entered if";
                            while ($row = $result->fetch_assoc()) {
                                $students[] = $row["title"];
                            }
                        } else {
                            echo "<p>Sorry, we currentally do not have any avaliable jobs.</p>";
                        }
                    }
                    foreach (array_unique($students) as $key) {
                        echo $key."<br>";
                    }
                ?>
            </div>
            <div class="display-company">
                <?php
                    $students = [];
                    foreach ($company_query_result as $result) {
                        if ($result->num_rows > 0) {
                            echo "entered if";
                            while ($row = $result->fetch_assoc()) {
                                $students[] = $row["cname"];
                            }
                        } else {
                            echo "<p>Sorry, we currentally do not have any avaliable companies.</p>";
                        }
                    }
                    foreach (array_unique($students) as $key) {
                        echo $key."<br>";
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
