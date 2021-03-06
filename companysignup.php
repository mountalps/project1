<?php
/**
 * Created by PhpStorm.
 * User: wesley
 * Date: 4/26/18
 * Time: 17:01
 */
include_once './lib/fun.php';
include_once './lib/dbinfo.php';

$cusername = htmlspecialchars($_POST['cusername']);
$cpassword = htmlspecialchars($_POST['cpassword']);
$cname = htmlspecialchars($_POST['cname']);
$ccity = htmlspecialchars($_POST['ccity']);
$cstate = htmlspecialchars($_POST['cstate']);
$ccountry = htmlspecialchars($_POST['ccountry']);
$industry = htmlspecialchars($_POST['industry']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company Sign Up</title>
</head>
<body>

<?php if($cusername == null || $cpassword == null ||$cname == null||$ccity == null||$cstate == null||$ccountry == null||$industry == null):?>

    <?php if($cusername == null):?>
        <h1>Please input your username!</h1>
    <?php endif;?>

    <?php if($cpassword == null):?>
        <h1>Please input your password!</h1>
    <?php endif;?>

    <?php if($cname == null):?>
        <h1>Please input your name!</h1>
    <?php endif;?>

    <?php if($ccity == null):?>
        <h1>Please input your city!</h1>
    <?php endif;?>

    <?php if($cstate == null):?>
        <h1>Please input your state!</h1>
    <?php endif;?>

    <?php if($ccountry == null):?>
        <h1>Please input your country!</h1>
    <?php endif;?>

    <?php if($industry == null):?>
        <h1>Please input your industry!</h1>
    <?php endif;?>
    <button onclick="window.location.href='index.html'">Return To Start Page</button>

<?php else:?>

    <?php

    $cpassword = encryptPassword($cpassword);
//    $connect = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
    $conn_protect = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase);
    $sqlConfirmNoDuplicate = $conn_protect->prepare("(select cid as num from Company where cusername = ?) union (select sid as num from Student where username=?);");
    $sqlConfirmNoDuplicate->bind_param("ss", $username_protect, $username_protect);
    $username_protect = $cusername;
    $sqlConfirmNoDuplicate->execute();
    $confirmResult = $sqlConfirmNoDuplicate->get_result();
    $confirmResult = $confirmResult->fetch_all();
    
//    $sqlConfirmNoDuplicate = "(select cid as num from Company where cusername = '{$cusername}') union (select sid as num from Student where username='{$cusername}');";
//    $resultConfirmNoDuplicate = mysqli_query($connect, $sqlConfirmNoDuplicate);
//    $confirmResult = mysqli_fetch_all($resultConfirmNoDuplicate, MYSQLI_ASSOC);

    ?>

    <?php if(count($confirmResult)!=0):?>
        <h3>Your username has been occupied! Please sign up again</h3>
        <button onclick="window.location.href='index.html'">Return To Start Page</button>
    <?php else:?>
        <?php
        
        $conn_protect = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase);
        $createCompanyAccount = $conn_protect->prepare("insert into Company (cid, cusername, cpassword, cname, ccity, cstate, ccountry, industry) values(?,?,?,?,?,?,?,?);");
        $createCompanyAccount->bind_param("dsssssss", $cid_protect, $cusername_protect, $cpassword_protect, $cname_protect, $ccity_protect, $cstate_protect, $ccountry_protect, $industry_protect);
        $cid_protect = null;
        $cusername_protect = $cusername;
        $cpassword_protect = $cpassword;
        $cname_protect = $cname;
        $ccity_protect = $ccity;
        $cstate_protect = $cstate;
        $ccountry_protect = $ccountry;
        $industry_protect = $industry;
        $createCompanyAccount->execute();
        $affectedRows = $createCompanyAccount->affected_rows;
        if ($affectedRows >= 1)
            $result = 'true';
        else
            $result = 'false';
        
//        $sql = "insert into Company values
//(null, '{$cusername}', '{$cpassword}', '{$cname}', '{$ccity}', '{$cstate}', '{$ccountry}', '{$industry}');";
//        $result = mysqli_query($connect, $sql);
//        var_dump($result);
        ?>

        <?php if ($result == 'true'):?>
            <h2>You Sign Up Successfully!</h2>
            <button onclick="window.location.href='index.html'">Back to login</button>
            <?php

            session_start();
            $_SESSION['user'] = $cusername;
            header('Location:./zq/0_company-homepage.php');
            exit;
            ?>
        <?php else:?>
            <h2>Sign Up Unsuccessfully!</h2>

        <?php endif;?>

    <?php endif;?>


<?php endif;?>


</body>
</html>
