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
    if ($checkUser == "student"){
        header('Location: 0_company-homepage.php');
        exit;
    }

    session_start();
    $username = $_SESSION['user'];

?>
