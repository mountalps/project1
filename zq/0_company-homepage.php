<?php
    include_once '../lib/fun.php';
    include_once '../lib/dbinfo.php';
    
    $checkUser = checkLogin();
//    var_dump($checkUser);
    if ($checkUser == "student"){
        header('Location: 0_student-homepage.php');
        exit;
    }
    
    session_start();
    $username = $_SESSION['user'];
    $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
    $sqlGetCompanyInfo = "select * from Company where cusername = '{$username}';";
    $resultCompanyInfo = mysqli_query($conToDB, $sqlGetCompanyInfo);
    $companyInfo = mysqli_fetch_all($resultCompanyInfo, MYSQLI_ASSOC);
    $_SESSION['companyInfo'] = $companyInfo;
    
//    var_dump($companyInfo);
    
    $cid = $companyInfo[0]['cid'];
    $sqlGetAvailableJobInfo = "select * from Job where cid = '{$cid}' and expirationDate > now();";
    $resultAvailableJobInfo = mysqli_query($conToDB, $sqlGetAvailableJobInfo);
    $availableJobInfo = mysqli_fetch_all($resultAvailableJobInfo, MYSQLI_ASSOC);
//    var_dump($availableJobInfo);
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
    
    
    
<!--    <div class="wrapper">-->
<!--      <div>-->
<!--      --><?php
//      // get the sid from signin page
//      session_start();
//      $username = $_SESSION['user'];
//
//      // database connection
//      $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
//      if ($conn->connect_error) {
//          die("Connection failed: " . $conn->connect_error);
//      }
//      $query = "SELECT cname FROM Company c WHERE c.cusername ='".$username."';";
//      $result = $conn->query($query);
//      $cname = "";
//      if ($result->num_rows > 0) {
//          while ($row = $result->fetch_assoc()) {
//              $cname = $row['cname'];
//          }
//      }
//      // the rest of the text
//      $hellostr = "Hello " . $cname . ",";
//      echo "<h2>$hellostr</h2>";
//      ?>
<!--      </div>-->
<!--      <div class="published-jobs">-->
<!--      --><?php
//      $query = "
//      SELECT j.title, j.jcity, j.jstate, j.jcountry, j.salary, c.cname, j.jdesciption, j.major, j.degree FROM Job j, Company c where j.cid = c.cid and c.cid = ".$cid.";";
//      $result = $conn->query($query);
//      if ($result->num_rows > 0) {
//        echo "<br><br>Here are published jobs of your company:<br><br>";
//          while ($row = $result->fetch_assoc()) {
//            echo "<div class='company-job'><p>";
//            echo $row['title'];
//            echo " in ".$row['jcity'].", ".$row['jstate'].", ".$row['jcountry'];
//            echo ", looking for students have ".$row['degree']." degree in ".$row['major'];
//            echo "</p></div>";
//          }
//      } else {
//        echo "<br><br>You have not published any jobs yet.<br><br>";
//      }
//      $conn->close();
//      ?>
<!--      </div>-->
<!--    </div>-->

<div class="job_display">
    <?php echo "<h2>Hello! {$companyInfo[0]['cusername']}</h2>"?>
    <h2>Here are all your available jobs:</h2>
    <?php foreach ($availableJobInfo as &$job): ?>
        <?php
            $sqlGetApplications = "select * from Application where tocid = '{$companyInfo[0]['cid']}' and jid = '{$job['jid']}';";
            $resultApplications = mysqli_query($conToDB, $sqlGetApplications);
            $applications = mysqli_fetch_all($resultApplications, MYSQLI_ASSOC);
//            var_dump($applications[0]);
        ?>
        <table border="1 pix">
            <tr>
                <td>Title</td>
                <td><?php echo "{$job['title']}";?></td>
            </tr>
            <tr>
                <td>City</td>
                <td><?php echo "{$job['jcity']}";?></td>
            </tr>
            <tr>
                <td>State</td>
                <td><?php echo "{$job['jstate']}";?></td>
            </tr>
            <tr>
                <td>Country</td>
                <td><?php echo "{$job['jcountry']}";?></td>
            </tr>
            <tr>
                <td>Degree</td>
                <td><?php echo "{$job['degree']}";?></td>
            </tr>
            <tr>
                <td>Major</td>
                <td><?php echo "{$job['major']}";?></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><?php echo "{$job['jdescription']}";?></td>
            </tr>
            <tr>
                <td>Expires</td>
                <td><?php echo "{$job['expirationDate']}";?></td>
            </tr>
            
        </table>
        <div>Applicants:</div>
        <?php foreach ($applications as &$application): ?>
            <?php
            $sqlGetApplicants = "select * from Student where sid = '{$application['fromsid']}';";
            $resultApplicants = mysqli_query($conToDB, $sqlGetApplicants);
            $applicants = mysqli_fetch_all($resultApplicants, MYSQLI_ASSOC);
            ?>
            <?php foreach ($applicants as &$applicant): ?>
                <form action="company_check_student.php" method="post">
                    <button type="submit" name="sid" value="<?php echo $applicant['sid']; ?>"><?php echo $applicant['sname']; ?></button>
                </form>
            <?php endforeach;?>
        <?php endforeach;?>
        <br>
        <br>
        <br>
    
    <?php endforeach;?>
    
    

</div>


</body>
</html>
