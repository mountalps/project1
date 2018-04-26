<?php
/**
 * Created by PhpStorm.
 * User: wesley
 * Date: 4/26/18
 * Time: 15:56
 */

$signUpCategory = $_POST['signUpRadio'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <h1 align="center">Welcome to join us !!!!</h1>
    <hr>

        <!---------------------------------------------------------------------->
        <!--------------When the client select to sign up as a student:--------->
    <?php if($signUpCategory == "student"): ?>
        <h1>Student Sign Up:</h1>
        <h2>please fill in this form, * means required</h2>
        <p>If you do not want clients who are not your friends or followed by you to see details in your profile,please select "Yes" in Restrict</p>

    <!--
    CREATE TABLE `Student`
    (
  `sid` INT NOT NULL auto_increment,
  `username` VARCHAR(20) NOT NULL,
  `password` VARCHAR(20) NOT NULL,
  `sname` VARCHAR(20) NOT NULL,
  `university` VARCHAR(100) ,
  `major` VARCHAR(20),
  `degree` VARCHAR(20),
  `GPA` DECIMAL(3,2) ,
  `keywords` VARCHAR(500),
  `resume` Varchar(20),
  `restrict` bit NOT NULL,
  PRIMARY KEY (`sid`)
  );
  -->
    <div align="center">
            <form action="studentsignup.php" method="post">
                <table>
                    <tr>
                        <td>Username*:</td>
                        <td><input type="text" name = "username"  size="35"></td>
                    </tr>

                    <tr>
                        <td>Password*:</td>
                        <td><input type="text" name="password" size="35"></td>
                    </tr>

                    <tr>
                        <td>You name*:</td>
                        <td><input type="text" name="sname" size="35"></td>
                    </tr>
                    <tr>
                        <td>University:</td>
                        <td><input type="text" name="university" size="35"></td>
                    </tr>
                    <tr>
                        <td>Major:</td>
                        <td><input type="text" name="major" size="35"></td>
                    </tr>
                    <tr>
                        <td>Degree:</td>
                        <td><input type="text" name="degree" size="35"></td>
                    </tr>
                    <tr>
                        <td>GPA:</td>
                        <td><input type="text" name="GPA" size="35"></td>
                    </tr>
                    <tr>
                        <td>Keywords:</td>
                        <td><input type="text" name="keywords" size="35"></td>
                    </tr>
                    <tr>
                        <td>Resume:</td>
                        <td><input type="file" name="resume" size="35"></td>
                    </tr>
                    <tr>
                        <td>Restrict:</td>
                        <td>
                            <select name="restrict" id="">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="right"><input type="submit" value="Sign up"></td>
                    </tr>
                </table>


            </form>
        </div>



        <!------------------------------------------------------------------------->
        <!--------------When the client select to sign up as a Company:-------------->
    <?php elseif ($signUpCategory == "company"): ?>
        <h1>Company Sign Up</h1>
        <h2>please fill in this form, * means required</h2>

        <!--
        CREATE TABLE `Company` (
        `cid` INT NOT NULL auto_increment,
        `cusername` VARCHAR(20) NOT NULL,
        `cpassword` VARCHAR(20) NOT NULL,
        `cname` VARCHAR(20) NOT NULL,
        `ccity` VARCHAR(20) NOT NULL,
        `cstate` VARCHAR(20) NOT NULL,
        `ccountry` VARCHAR(20) NOT NULL,
        `industry` VARCHAR(100) NOT NULL,
        PRIMARY KEY (`cid`));
      -->
        <div align="center">
            <form action="companysignup.php" method="post">
                <table>
                    <tr>
                        <td>Username*:</td>
                        <td><input type="text" name = "cusername"  size="35"></td>
                    </tr>

                    <tr>
                        <td>Password*:</td>
                        <td><input type="text" name="cpassword" size="35"></td>
                    </tr>
                    <tr>
                        <td>Company Name*:</td>
                        <td><input type="text" name = "cname"  size="35"></td>
                    </tr>

                    <tr>
                        <td>city*:</td>
                        <td><input type="text" name="ccity" size="35"></td>
                    </tr>

                    <tr>
                        <td>state*:</td>
                        <td><input type="text" name="cstate" size="35"></td>
                    </tr>
                    <tr>
                        <td>country*:</td>
                        <td><input type="text" name="ccountry" size="35"></td>
                    </tr>
                    <tr>
                        <td>industry*:</td>
                        <td><input type="text" name="industry" size="35"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="right"><input type="submit" value="Sign up"></td>
                    </tr>
                </table>


            </form>
        </div>

    <?php endif;?>

</body>
</html>
