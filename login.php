<?php
/**
 * Created by PhpStorm.
 * User: wesley
 * Date: 4/26/18
 * Time: 15:56
 */
include_once './lib/fun.php';
include_once './lib/dbinfo.php';

$username = trim($_POST['username']);
$password = trim($_POST['password']);
$loginCategory = $_POST['loginRadio'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

    <?php if($username == null || $password == null ||$loginCategory == null):?>
        <?php if($username == null):?>
            <h1 >Please input your username!</h1>
        <?php endif;?>

        <?php if($password == null):?>
            <h1>Please input your password!</h1>
        <?php endif;?>

        <?php if($loginCategory == null):?>
            <h1>Please select your category!</h1>
        <?php endif;?>


    <?php else:?>
        <?php if($loginCategory == "student"):?>
        <?php
            $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
            $sql = "select * from Student where username = '{$username}'";
            $result = mysqli_query($conToDB, $sql);
            $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>
        <?php if (is_array($result) && !empty($result)):?>

            <?php if(encryptPassword($password) === $result[0]['password']):?>
                <?php
                    echo 'success!';
                    $_SESSION['user'] = $username;
                    header('Location:./zq/0_student-homepage.php');
                    exit;
                ?>
            <?php else:?>
                <h1>Your password is incorrect! Please Try Again</h1>
                    <button onclick="window.location.href='index.html'">Back to login</button>
                <?php endif;?>

            <?php  else:?>
                <h1>Your username doesn't exit! Please Try Again</h1>
                <button onclick="window.location.href='index.html'">Back to login</button>

        <?php endif;?>
    <?php endif;?>


        <?php if($loginCategory === "company"):?>
                <?php
//            echo '111';
                $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);

//            if (!$conToDB){
//                echo 'connection failed!';
//                exit;
//            }
//            else{
//                echo 'connection success!';
//            }
                $sql = "select * from Company where cusername = '{$username}'";
                $result = mysqli_query($conToDB, $sql);
                $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
                ?>
                <?php if (is_array($result) && !empty($result)):?>
                    <?php if(encryptPassword($password) === $result[0]['cpassword']):?>
                        <?php
                        echo 'success!';
                        $_SESSION['user'] = $username;
                        header('Location:./zq/0_company-homepage.php');
                        exit;
                        ?>
                    <?php else:?>
                        <h1>Your password is incorrect! Please Try Again</h1>
                        <button onclick="window.location.href='index.html'">Back to login</button>
                    <?php endif;?>
                <?php  else:?>
                    <h1>Your username doesn't exit! Please Try Again</h1>
                    <button onclick="window.location.href='index.html'">Back to login</button>

                <?php endif;?>

        <?php endif;?>

    <?php endif;?>

</body>
</html>
