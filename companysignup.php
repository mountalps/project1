<?php
/**
 * Created by PhpStorm.
 * User: wesley
 * Date: 4/26/18
 * Time: 17:01
 */
include_once './lib/fun.php';
include_once './lib/dbinfo.php';

$cusername = $_POST['cusername'];
$cpassword = $_POST['cpassword'];
$cname = $_POST['cname'];
$ccity = $_POST['ccity'];
$cstate = $_POST['cstate'];
$ccountry = $_POST['ccountry'];
$industry = $_POST['industry'];

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

    $password = encryptPassword($password);
    $connect = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
    $sqlConfirmNoDuplicate = "select * from Student where username = '{$username}';";
    $resultConfirmNoDuplicate = mysqli_query($connect, $sqlConfirmNoDuplicate);
    $confirmResult = mysqli_fetch_all($resultConfirmNoDuplicate, MYSQLI_ASSOC);

    ?>

    <?php if(count($confirmResult)!=0):?>
        <h3>Your username has been occupied! Please sign up again</h3>
        <button onclick="window.location.href='index.html'">Return To Start Page</button>
    <?php else:?>
        <?php
        $sql = "insert into Company values
(null, '{$cusername}', '{$cpassword}', '{$cname}', '{$ccity}', '{$cstate}', '{$ccountry}', '{$industry}');";
        $result = mysqli_query($connect, $sql);
        var_dump($result);
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