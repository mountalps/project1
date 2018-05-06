<?php
    /**
     * Created by PhpStorm.
     * User: wesley
     * Date: 5/6/18
     * Time: 15:30
     */
    
    include_once '../lib/fun.php';
    include_once '../lib/dbinfo.php';
    
    session_start();
    $username = $_SESSION['user'];
    $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
    $sqlGetCompanyInfo = "select * from Company where cusername = '{$username}';";
    $resultCompanyInfo = mysqli_query($conToDB, $sqlGetCompanyInfo);
    $companyInfo = mysqli_fetch_all($resultCompanyInfo, MYSQLI_ASSOC);
    
    $cid = $companyInfo[0]['cid'];
    $sqlGetAvailableJobInfo = "select * from Job where cid = '{$cid}' and expirationDate > now();";
    $resultAvailableJobInfo = mysqli_query($conToDB, $sqlGetAvailableJobInfo);
    $availableJobInfo = mysqli_fetch_all($resultAvailableJobInfo, MYSQLI_ASSOC);

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div class="navivation">
    <nav>
        <div class="wrapper">
            <a class="active" href="0_company-homepage.php">Home</a> |
            <a href="company_notifications.php">Notifications</a> |
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

<div class="Push jobs">
    <h2>Please input your criteria</h2>
    <h3>If you don't have criteria in some attribute, please leave it blank</h3>
    <form action="company_push_jobs_result.php" method="post">
        <table>
            <tr>
                <td>University:</td>
                <td><input type="text" name="university" size="35"></td>
            </tr>
            <tr>
                <td>Major:</td>
                <td><input type="text" name="major" size="35"></td>
            </tr>
            <tr>
                <td>Degree:</td>
                <td><input type="text" name="degree" size="35"></td>
            </tr>
            <tr>
                <td>GPA:</td>
                <td><input type="text" name="GPA" size="35"></td>
            </tr>
            <tr>
                <td>Job ID</td>
                <td>
                    <select name="job_id" id="">
                        <?php foreach ($availableJobInfo as &$job): ?>
                            <?php echo "<option value='{$job['jid']}'>{$job['jid']}-{$job['title']}</option>"?>
                        <?php endforeach;?>
                    </select>
                    (only availabe jobs listed here)
                </td>
            </tr>
            
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td align="right"><input type="submit" value="Push"></td>
            </tr>
        </table>
    
    
    </form>
    
</div>


</body>
</html>
