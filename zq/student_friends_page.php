<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Friends</title>
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
    <h2>This is a friend page!</h2>
</body>
</html>