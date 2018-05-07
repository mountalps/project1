<?php
    /**
     * Created by PhpStorm.
     * User: wesley
     * Date: 5/6/18
     * Time: 10:31
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

    $password = htmlspecialchars($_POST['password']);
    $sname = htmlspecialchars($_POST['sname']);
    $university = htmlspecialchars($_POST['university']);
    $major = htmlspecialchars($_POST['major']);
    $degree = htmlspecialchars($_POST['degree']);
    $GPA = htmlspecialchars($_POST['GPA']);
    $keywords = htmlspecialchars($_POST['keywords']);
    $resume = htmlspecialchars($_POST['resume']);
    $restrict = htmlspecialchars($_POST['restrict']);
    // var_dump($restrict);

//    var_dump($username);
//    var_dump($cpassword);
//    var_dump($cname);
//    var_dump($ccity);
//    var_dump($cstate);
//    var_dump($ccountry);
//    var_dump($industry);
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

<div class="wrapper">
    <?php
//        $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
//        $cpassword = $_POST['cpassword'];
//        $cname = $_POST['cname'];
//        $ccity = $_POST['ccity'];
//        $cstate = $_POST['cstate'];
//        $ccountry = $_POST['ccountry'];
//        $industry = $_POST['industry'];
        $conn_protect = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase);
        if ($password != ""){
            $password = encryptPassword($password);
            $sqlChangePassword = $conn_protect->prepare("update Student set password=? where username=?;");
            $sqlChangePassword->bind_param("ss", $password_protect, $username_protect);
//            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $password_protect = $password;
            $username_protect = $username;
            $sqlChangePassword->execute();
            $sqlChangePassword->close();
//            $resultChangePassword = mysqli_query($conToDB, $sqlChangePassword);
//            echo 'resultChangePassword:';
//            var_dump($resultChangePassword);
//            echo '<br>';
        }

        if ($sname != ""){

//            $sqlChangeName = "update Company set cname='{$cname}' where cusername='{$username}';";
//            $resultChangeName = mysqli_query($conToDB, $sqlChangeName);
//            echo 'resultChangeName:';
//            var_dump($resultChangeName);
//            echo '<br>';

            $sqlChangeName = $conn_protect->prepare("update Student set sname=? where username=?;");
            $sqlChangeName->bind_param("ss", $sname_protect, $username_protect);
//            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $sname_protect = $sname;
            $username_protect = $username;
            $sqlChangeName->execute();
            // $sqlChangeName->close();

        }

        if ($university != ""){

//            $sqlChangeCity = "update Company set ccity='{$ccity}' where cusername='{$username}';";
//            $resultChangeCity = mysqli_query($conToDB, $sqlChangeCity);
//            echo 'resultChangeCity:';
//            var_dump($resultChangeCity);
//            echo '<br>';

            $sqlChangeUniversity = $conn_protect->prepare("update Student set university=? where username=?;");
            $sqlChangeUniversity->bind_param("ss", $university_protect, $username_protect);
//            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $university_protect = $university;
            $username_protect = $username;
            // $username_protect =
            $sqlChangeUniversity->execute();
            // $sqlChangeUniversity->close();

        }


        if ($major != ""){

//            $sqlChangeState = "update Company set cstate='{$cstate}' where cusername='{$username}';";
//            $resultChangeState = mysqli_query($conToDB, $sqlChangeState);
//            echo 'resultChangeState:';
//            var_dump($resultChangeState);
//            echo '<br>';

            $sqlChangeMajor = $conn_protect->prepare("update Student set major=? where username=?;");
            // var_dump($sqlChangeMajor);
            $sqlChangeMajor->bind_param("ss", $major_protect, $username_protect);
//            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $major_protect = $major;
            $username_protect = $username;
            $sqlChangeMajor->execute();
            // $sqlChangeMajor->close();

        }

        if ($degree != ""){

//            $sqlChangeCountry = "update Company set ccountry='{$ccountry}' where cusername='{$username}';";
//            $resultChangeCountry = mysqli_query($conToDB, $sqlChangeCountry);
//            echo 'resultChangeCountry:';
//            var_dump($resultChangeCountry);
//            echo '<br>';

            $sqlChangeDegree  = $conn_protect->prepare("update Student set degree=? where username=?;");
            $sqlChangeDegree->bind_param("ss", $degree_protect, $username_protect);
//            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $degree_protect = $degree;
            $username_protect = $username;
            $sqlChangeDegree->execute();
            // $sqlChangeDegree->close();

        }

        if ($GPA != ""){

//            $sqlChangeIndustry = "update Company set industry='{$industry}' where cusername='{$username}';";
//            $resultChangeIndustry = mysqli_query($conToDB, $sqlChangeIndustry);
//            echo 'resultChangeIndustry:';
//            var_dump($resultChangeIndustry);
//            echo '<br>';

            $sqlChangeGPA  = $conn_protect->prepare("update Student set GPA=? where username=?;");
            $sqlChangeGPA->bind_param("ss", $gpa_protect, $username_protect);
//            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $gpa_protect = $GPA;
            $username_protect = $username;
            $sqlChangeGPA->execute();
            // $sqlChangeGPA->close();

        }

        if ($keywords != ""){

//            $sqlChangeIndustry = "update Company set industry='{$industry}' where cusername='{$username}';";
//            $resultChangeIndustry = mysqli_query($conToDB, $sqlChangeIndustry);
//            echo 'resultChangeIndustry:';
//            var_dump($resultChangeIndustry);
//            echo '<br>';

            $sqlChangeKeywords  = $conn_protect->prepare("update Student set keywords=? where username=?;");
            $sqlChangeKeywords->bind_param("ss", $keywords_protect, $username_protect);
//            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $keywords_protect = $keywords;
            $username_protect = $username;
            $sqlChangeKeywords->execute();
            // $sqlChangeKeywords->close();

        }

        if ($resume != ""){

//            $sqlChangeIndustry = "update Company set industry='{$industry}' where cusername='{$username}';";
//            $resultChangeIndustry = mysqli_query($conToDB, $sqlChangeIndustry);
//            echo 'resultChangeIndustry:';
//            var_dump($resultChangeIndustry);
//            echo '<br>';

            $sqlChangeResume  = $conn_protect->prepare("update Student set resume=? where username=?;");
            $sqlChangeResume->bind_param("ss", $resume_protect, $username_protect);
//            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $resume_protect = $resume;
            $username_protect = $username;
            $sqlChangeResume->execute();
            // $sqlChangeResume->close();

        }

        if ($restrict != ""){

//            $sqlChangeIndustry = "update Company set industry='{$industry}' where cusername='{$username}';";
//            $resultChangeIndustry = mysqli_query($conToDB, $sqlChangeIndustry);
//            echo 'resultChangeIndustry:';
//            var_dump($resultChangeIndustry);
//            echo '<br>';
            if ($restrict == 'yes') {
                $restrict = '1';
            } else {
                $restrict = '0';
            }
            $sqlChangeRestrict  = $conn_protect->prepare("update Student set `restrict`=? where username=?;");
            // var_dump($sqlChangeRestrict);
            $sqlChangeRestrict->bind_param("ss", $restrict_protect, $username_protect);
//            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $restrict_protect = $restrict;
            $username_protect = $username;
            $sqlChangeRestrict->execute();
            // $sqlChangeRestrict->close();

        }
        ?>
</div>

<div class="changeResult" align="center">
    <h3>Here is your new profile</h3>
    <?php
    echo $sname.'<br>';
    echo $university.'<br>';
    echo $major.'<br>';
    echo $degree.'<br>';
    echo $GPA.'<br>';
    echo $keywords.'<br>';
    echo $resume.'<br>';
    echo $restrict.'<br>';
     ?>
</div>

</body>
</html>
