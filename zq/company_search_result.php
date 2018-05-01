<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your Jobs</title>
    <style>
        form {display: inline-block;}
        nav {background-color: #EEE}
        .wrapper {padding: 0 60px 0 60px;}
    </style>
</head>
<body>
    <div class="navivation">
        <nav>
          <div class="wrapper">
            <a class="active" href="0_company-homepage.php">Home</a> |
            <a href="company_notifications.php">Notifications</a> |
            <a href="company_jobs.php">Your Jobs</a> |
            <a href="company_publish_jobs.php">Publish A Job</a> |
            <form action="company_search_result.php" method="get" id="keyword_search">
                <input type="text" placeholder="Search..." name="keyword">
                <button type="submit">search</button>
            </form>
          </div>
        </nav>
    </div>
    <?php
    $DBhost = $_SESSION["DBhost"];
    echo "$DBhost";
    $hellostr = "here are your search results";
    echo "<h1>$hellostr</h1>";
    ?>
    <h2>Search Result:</h2>
    <?php
    $keyword = $_GET["keyword"];
    $pieces = explode(" ", $keyword);
    echo "$keyword </br>";
    //echo count($pieces);
    foreach($pieces as $k){
        echo "$k<br>";
    }
    ?>
</body>
</html>
