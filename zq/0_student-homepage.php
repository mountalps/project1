<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jobster Home</title>
    <style>
        form {display: inline-block;}
    </style>
</head>
<body>
    <div class="navivation">
        <nav>
            <a class="active" href="0_student-homepage.php">Home</a> |
            <a href="student_notifications.php">Notifications</a> |
            <a href="student_friends_page.php">Friends</a> |
            <a href="student_followed_companies.php">Followed Companies</a> |
            <a href="student_applied_jobs.php">Applied Jobs</a> |
            <form action="student_search_result.php" method="get" id="keyword_search">
                <input type="text" placeholder="Search..." name="keyword">
                <button type="submit">search</button>
            </form>
        </nav>
    </div>
    <?php
    // get the sid from signin page
    $sid = $_SESSION['studentid'];
    $sid = 1;
    
    // database connection
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "PJ2database";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $query = "SELECT sname FROM Student s WHERE s.sid = 1";
    $result = $conn->query($query);
    $sname = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sname = $row;
        }
    }

    // the rest of the text
    $hellostr = "Hello, " . $sname;
    echo "<h2>$hellostr</h2>";
    ?>
    <div>
    Here are some avaliable jobs:<br>
    </div>
    <?php
    $query = "SELECT * FROM Job j, Company c where j.cid = c.cid";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // echo $row["cname"];
            echo 
            "<div>
            Job Title: " . $row["title"] . "<br>    By Company: " . $row["cname"] . "<br><br>"
            . "
            </div>";
        }
    }
    $conn->close();
    ?>
</body>
</html>