<?php
    /**
     * Created by PhpStorm.
     * User: wesley
     * Date: 5/6/18
     * Time: 19:02
     */
    
    session_start();
//释放user
    unset($_SESSION['user']);
    header('Location:../index.html');
    exit;
?>
