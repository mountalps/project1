<?php
    include_once './lib/fun.php';
    include_once './lib/dbinfo.php';
    
//    $conToDB = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
//    var_dump($conToDB);

//    $connect = mysqlInit($DBhost, $DBuser, $DBpassword, $DBdatabase, $port);
//    $sqlConfirmNoDuplicate = "(select cid as num from Company where cusername = '{$username}') union (select sid as num from Student where username='{$username}');";
//    $resultConfirmNoDuplicate = mysqli_query($connect, $sqlConfirmNoDuplicate);
//    $confirmResult = mysqli_fetch_all($resultConfirmNoDuplicate, MYSQLI_ASSOC);
    
    $conn_protect = new mysqli($DBhost, $DBuser, $DBpassword, $DBdatabase);
//    var_dump($conn);
//    var_dump($conn->connect_error);
    if ($conn_protect->connect_error) {
        die("Connection failed: " . $conn_protect->connect_error);
    }
    
    
    $login = $conn_protect->prepare("(select cid as num from Company where cusername = ?) union (select sid as num from Student where username=?);");
    $login->bind_param("ss", $username_protect, $username_protect);
    $username_protect = 'xxx';
    $login->execute();
    $confirmResult = $login->get_result();
    $confirmResult = $confirmResult->fetch_all();
//    var_dump($confirmResult);
    
    $login->bind_result($login);
    $login->fetch();
    
//    var_dump($sqlConfirmNoDuplicate);
    
    $createStudentAccount = $conn_protect->prepare("insert into Student (sid, username, password, sname, university, major, degree, GPA, keywords, `restrict`) values(?,?,?,?,?,?,?,?,?,?);");
    $createStudentAccount->bind_param("dssssssdss", $sid_protect, $username_protect, $password_protect, $sname_protect, $university_protect, $major_protect, $degree_protect, $GPA_protect, $keywords_protect, $restrict_protect);
    var_dump($createStudentAccount);
    $sid_protect = 105;
    $username_protect = "xxx";
    $password_protect = "yyy";
    $sname_protect = "Jack";
    $university_protect = "888";
    $major_protect = "CS";
    $degree_protect = "Master";
    $GPA_protect = 3.0;
    $keywords_protect = "hahaha";
    $restrict_protect = "1";
    $createStudentAccount->execute();
//    var_dump($sid_protect);
    
    
//    $sqlGetCompanyInfo = "select * from Company where cusername = '{$username}';";
//    $resultCompanyInfo = mysqli_query($conToDB, $sqlGetCompanyInfo);
//    $companyInfo = mysqli_fetch_all($resultCompanyInfo, MYSQLI_ASSOC);
//    $_SESSION['companyInfo'] = $companyInfo;
?>