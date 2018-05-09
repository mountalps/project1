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
    $jid = $_POST['jid'];
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

<div class="job_display">
    <?php echo "<h2>Hello! {$companyInfo[0]['cusername']}</h2>"?>
        <?php
        // echo $jid;
            $job =  $conToDB->query("select c.cid, j.title, j.jcity, j.jstate, j.jcountry, j.degree, j.major, j.jdescription, j.expirationDate, c.cname from Job j, Company c where j.cid = c.cid and j.jid = {$jid};")->fetch_assoc();
           // var_dump($job['cid']);
        ?>
        <table border="1 pix">
            <tr>
                <td>Title</td>
                <td><?php echo $job['title'];?></td>
            </tr>
            <tr>
                <td>Company</td>
                <td>
                <form class="company-info" action="company_info_for_company.php" method="post">
                    <button type="submit" name="cid" value="<?php echo $job['cid']; ?>"><?php echo $job['cname']; ?></button>
                </form>
                </td>
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

</div>


</body>
</html>
