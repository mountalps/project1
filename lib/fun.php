<?php
/**
 * Created by PhpStorm.
 * User: wesley
 * Date: 4/30/18
 * Time: 07:34
 */


/**
 * Initiate the database connection
 * @param $DBhost
 * @param $DBuser
 * @param $DBpassword
 * @param $DBdatabase
 * @return bool|mysqli
 */
function mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase){
    $connect = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBdatabase);
    mysqli_query($connect, 'set names utf8');
    if (!$connect)
        return false;

    return $connect;
}


/**
 * Encrypt the password clients type in
 * @param $password
 * @return bool|string
 */
function encryptPassword($password){
    if (!$password)
        return false;

    return md5(md5($password).'Jobster');
}


/**
 * check whether the client is logging in.
 * @return bool
 */
function checkLongin(){
    session_start();
    if (!isset($_SESSION['user']) || empty($_SESSION['user'])){
        return false;
    }

    return true;
}