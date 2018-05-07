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
    if ($checkUser == "student"){
        header('Location: 0_student-homepage.php');
        exit;
    }
    
    session_start();
    $username = $_SESSION['user'];
    
    $cpassword = htmlspecialchars($_POST['cpassword']);
    $cname = htmlspecialchars($_POST['cname']);
    $ccity = htmlspecialchars($_POST['ccity']);
    $cstate = htmlspecialchars($_POST['cstate']);
    $ccountry = htmlspecialchars($_POST['ccountry']);
    $industry = htmlspecialchars($_POST['industry']);
    
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
            <a class="active" href="0_company-homepage.php">Home</a> |
            <a href="company_jobs.php">Your Jobs</a> |
            <a href="company_publish_jobs.php">Publish A Job</a> |
            <a href="company_push_jobs.php">Push A Job</a> |
            <a href="company_modify_profile.php">Modify Profile</a> |
            <a href="../lib/logout.php">Log Out</a> |
            <!--          <form action="company_search_result.php" method="get" id="keyword_search">-->
            <!--              <input type="text" placeholder="Search..." name="keyword">-->
            <!--              <button type="submit">search</button>-->
            <!--          </form>-->
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
        
        if ($cpassword != ""){
            $cpassword = encryptPassword($cpassword);
            $sqlChangePassword = $conn_protect->prepare("update Company set cpassword=? where cusername=?;");
            $sqlChangePassword->bind_param("ss", $cpassword_protect, $cusername_protect);
//            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $cpassword_protect = $cpassword;
            $cusername_protect = $username;
            $sqlChangePassword->execute();
//            $resultChangePassword = mysqli_query($conToDB, $sqlChangePassword);
//            echo 'resultChangePassword:';
//            var_dump($resultChangePassword);
//            echo '<br>';
        }
        
        if ($cname != ""){

//            $sqlChangeName = "update Company set cname='{$cname}' where cusername='{$username}';";
//            $resultChangeName = mysqli_query($conToDB, $sqlChangeName);
//            echo 'resultChangeName:';
//            var_dump($resultChangeName);
//            echo '<br>';
            
            $sqlChangeName = $conn_protect->prepare("update Company set cname=? where cusername=?;");
            $sqlChangeName->bind_param("ss", $cname_protect, $cusername_protect);
//            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $cname_protect = $cname;
            $cusername_protect = $username;
            $sqlChangeName->execute();
            
        }
        
        if ($ccity != ""){

//            $sqlChangeCity = "update Company set ccity='{$ccity}' where cusername='{$username}';";
//            $resultChangeCity = mysqli_query($conToDB, $sqlChangeCity);
//            echo 'resultChangeCity:';
//            var_dump($resultChangeCity);
//            echo '<br>';
            
            $sqlChangeCity = $conn_protect->prepare("update Company set ccity=? where cusername=?;");
            $sqlChangeCity->bind_param("ss", $ccity_protect, $cusername_protect);
//            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $ccity_protect = $ccity;
            $cusername_protect = $username;
            $sqlChangeCity->execute();
            
        }
        
        
        if ($cstate != ""){

//            $sqlChangeState = "update Company set cstate='{$cstate}' where cusername='{$username}';";
//            $resultChangeState = mysqli_query($conToDB, $sqlChangeState);
//            echo 'resultChangeState:';
//            var_dump($resultChangeState);
//            echo '<br>';
            
            $sqlChangeState = $conn_protect->prepare("update Company set cstate=? where cusername=?;");
            $sqlChangeState->bind_param("ss", $cstate_protect, $cusername_protect);
//            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $cstate_protect = $cstate;
            $cusername_protect = $username;
            $sqlChangeState->execute();
            
        }
        
        if ($ccountry != ""){

//            $sqlChangeCountry = "update Company set ccountry='{$ccountry}' where cusername='{$username}';";
//            $resultChangeCountry = mysqli_query($conToDB, $sqlChangeCountry);
//            echo 'resultChangeCountry:';
//            var_dump($resultChangeCountry);
//            echo '<br>';
            
            $sqlChangeCountry  = $conn_protect->prepare("update Company set ccountry=? where cusername=?;");
            $sqlChangeCountry ->bind_param("ss", $ccountry_protect, $cusername_protect);
//            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $ccountry_protect = $ccountry;
            $cusername_protect = $username;
            $sqlChangeCountry ->execute();
            
        }
        
        if ($industry != ""){

//            $sqlChangeIndustry = "update Company set industry='{$industry}' where cusername='{$username}';";
//            $resultChangeIndustry = mysqli_query($conToDB, $sqlChangeIndustry);
//            echo 'resultChangeIndustry:';
//            var_dump($resultChangeIndustry);
//            echo '<br>';
            
            $sqlChangeIndustry  = $conn_protect->prepare("update Company set industry=? where cusername=?;");
            $sqlChangeIndustry ->bind_param("ss", $cindustry_protect, $cusername_protect);
//            $sqlChangePassword = "update Company set cpassword='{$cpassword}' where cusername='{$username}';";
            $cindustry_protect = $industry;
            $cusername_protect = $username;
            $sqlChangeIndustry ->execute();
            
        }
    ?>
</div>

<div class="changeResult" align="center">
    <h3>Here is your new profile</h3>
    <table>
        <tr>
            <td>Name: </td>
            <td><?php if ($cname != null)
                        echo $cname;
                      else
                          echo 'Not Changed!';
                ?>
            </td>
        </tr>
        <tr>
            <td>City: </td>
            <td><?php if ($ccity != null)
                    echo $ccity;
                else
                    echo 'Not Changed!';
                ?></td>
        </tr>
        <tr>
            <td>State: </td>
            <td><?php if ($cstate != null)
                    echo $cstate;
                else
                    echo 'Not Changed!';
                ?></td>
        </tr>
        <tr>
            <td>Country: </td>
            <td><?php if ($ccountry != null)
                    echo $ccountry;
                else
                    echo 'Not Changed!';
                ?></td>
        </tr>
        <tr>
            <td>Industry: </td>
            <td><?php if ($industry != null)
                    echo $industry;
                else
                    echo 'Not Changed!';
                ?></td>
        </tr>
    </table>

</div>




</body>
</html>
