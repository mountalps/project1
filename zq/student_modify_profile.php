<?php
/**
 * Created by PhpStorm.
 * User: wesley
 * Date: 5/5/18
 * Time: 23:06
 */
    include_once '../lib/fun.php';
    include_once '../lib/dbinfo.php';

    $checkUser = checkLogin();
    //    var_dump($checkUser);
    if ($checkUser != "student"){
        header('Location: 0_company-homepage.php');
        exit;
    }

    session_start();
    $username = $_SESSION['user'];
    $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jobster Student Home</title>
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
                <a href="student_modify_profile.php">Modify Profile</a> |
                <a href="../lib/logout.php">Log Out</a> |
                <form action="student_search_result.php" method="get" id="keyword_search">
                    <input type="text" placeholder="Search..." name="keyword">
                    <button type="submit">search</button>
                </form>
            </div>
        </nav>
    </div>
    <?php
    $row = $conn->query("select sname, university, major, degree, GPA, keywords, resume, `restrict` from Student where username = '{$username}';")->fetch_assoc();
    // var_dump($row);
    $sname = $row['sname'];
    $university = $row['university'];
    $major = $row['major'];
    $degree = $row['degree'];
    $gpa = $row['GPA'];
    $keywords = $row['keywords'];
    $resume = $row['resume'];
    $restrict = $row['restrict'];
    // var_dump($restrict);
    ?>
    <div class="wrapper">
    <div class="modify_student_profile">
        <h1>Please input what you want to change</h1>
        <h4>If you don't want to change some profile, just leave it blank</h4>
        <form action="student_modify_profile_result.php" method="post">
            <table>
                <tr>
                    <td>New Password:</td>
                    <td><input type="password" name="password" size="35"></td>
                </tr>

                <tr>
                    <td>You name:</td>
                    <td><input type="text" name="sname" size="35" placeholder="current: <?php echo $sname; ?>"></td>
                </tr>
                <tr>
                    <td>University:</td>
                    <td><input type="text" name="university" size="35" placeholder="current: <?php echo $university; ?>"></td>
                </tr>
                <tr>
                    <td>Major:</td>
                    <td><input type="text" name="major" size="35" placeholder="current: <?php echo $major; ?>"></td>
                </tr>
                <tr>
                    <td>Degree:</td>
                    <td><input type="text" name="degree" size="35" placeholder="current: <?php echo $degree; ?>"></td>
                </tr>
                <tr>
                    <td>GPA:</td>
                    <td><input type="text" name="GPA" size="35" placeholder="current: <?php echo $gpa; ?>"></td>
                </tr>
                <tr>
                    <td>Keywords:</td>
                    <td><input type="text" name="keywords" size="35" placeholder="current: <?php echo $keywords; ?>"></td>
                </tr>
                <tr>
                    <td>Resume:</td>
                    <td>
                        <textarea name="resume" rows="10" cols="50" maxlength="4800" placeholder="current: <?php echo $resume; ?>"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Restrict:</td>
                    <td>
                        <select name="restrict" id="">
                            <?php
                            if ($restrict == '1') {
                                ?>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                                <?php
                            } else {
                                ?>
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td align="right"><input type="submit" value="Modify"></td>
                </tr>
            </table>
        </form>
    </div>
    </div>
</body>
</html>
