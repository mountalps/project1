<?php
/**
 * Created by PhpStorm.
 * User: wesley
 * Date: 4/30/18
 * Time: 07:34
 */

//    var_dump(get_included_files());

    /**
 * Initiate the database connection
 * @param $DBhost
 * @param $DBuser
 * @param $DBpassword
 * @param $DBdatabase
 * @return bool|mysqli
 */
function mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port){
    $connect = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
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
//function checkLongin(){
//    session_start();
//    if (!isset($_SESSION['user']) || empty($_SESSION['user'])){
//        return false;
//    }
//
//    return true;
//}

    /**
     * check whether user login
     *
     */
    function checkLogin()
    {
        //开启session
        session_start();

        //用户未登录
        if(!isset($_SESSION['user']) || empty($_SESSION['user']))
        {
            header('Location:../index.html');
            exit;
        }
        else{

            $DBhost = 'dbprojectjobster.cinhv01qdhxv.us-east-2.rds.amazonaws.com';
            $DBuser = 'mountalps';
            $DBpassword = 'pt4-ovc-LMe-sVL';
            $DBdatabase = 'dbproject_new';
            $port = '3306';

            $username = $_SESSION['user'];

            $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
            $sqlGetCompanyInfo = "select * from Company where cusername = '{$username}';";
            $resultCompanyInfo = mysqli_query($conToDB, $sqlGetCompanyInfo);
            $companyInfo = mysqli_fetch_all($resultCompanyInfo, MYSQLI_ASSOC);

            $sqlGetStudentInfo = "select * from Student where username = '{$username}';";
            $resultStudentInfo = mysqli_query($conToDB, $sqlGetStudentInfo);
            $studentInfo = mysqli_fetch_all($resultStudentInfo, MYSQLI_ASSOC);


            if ($studentInfo[0] == null){
                if ($companyInfo[0] != null){
                    return "company";
                }
            }
            else{
                if ($companyInfo == null){
                    return "student";
                }
            }
        }

    }

?>
