<?php

$servername = "localhost";
$username = "root";
$password = "password";
$db = "website";

$conn = mysqli_connect($servername, $username, $password, $db);

function resultToArray($result)
{
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}

function getUser($user_email)
{
    global $conn;
    $sql = "SELECT * FROM `user` WHERE email='$user_email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    return $user;
}

SESSION_START();

if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
    $user_type = $_SESSION["user_type"];

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM `user` where email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    }

    $sql = "SELECT * FROM `post`";
    $result = mysqli_query($conn, $sql);

    $posts = resultToArray($result);
//    if ( mysqli_num_rows( $result ) == 1 ) {
//    }
} else {
    header("location: login-register.html");
}

?>

<html>

<head>
    <title>Messages</title>
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../CSS/messages.css">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../JS/posts.js"></script>
</head>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-nav-demo"
                    aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="../HTML/home.php" class="navbar-brand">Home</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-nav-demo">

            <ul class="nav navbar-nav navbar-right">
                <?php
                if ($user_type == "normal")
                    echo("<li><a href='normal-user-profile.php'>Profile</a></li>");
                else
                    echo "<li><a href='company-profile.php'>Profile</a></li>";
                ?>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="../HTML/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2 class="page-header">Messages</h2>
            <section class="comment-list">
                <?php
                $sql2 = "SELECT DISTINCT user2_email FROM message WHERE user1_email = '$email'
                         UNION 
                         SELECT DISTINCT user1_email FROM message WHERE user2_email = '$email'";

                $result1 = mysqli_query($conn, $sql2);

                $contacts = resultToArray($result1);

                foreach ($contacts as $contact) {
                    $user = getUser($contact['user2_email']);
                    echo('
                        <article class="row like" onclick="startConv(\'' . $email . '\', \'' . $contact['user2_email'] . '\')">
                                <div class="col-md-2 col-sm-2 hidden-xs">
                                    <figure class="thumbnail">
                                        <img class="img-responsive" src="' . '..\IMG\\' . $user['profile_picture'] . '" />
                                        <figcaption class="text-center">' . $user['name'] . '</figcaption>
                                    </figure>
                                </div>
                        </article>'
                    );
                }
                ?>
                <!--                <article class="row like">-->
                <!--                    <div class="col-md-2 col-sm-2 hidden-xs">-->
                <!--                        <figure class="thumbnail">-->
                <!--                            <img class="img-responsive" src="../IMG/undertaker.jpg"/>-->
                <!--                            <figcaption class="text-center">Ali Farouk</figcaption>-->
                <!--                        </figure>-->
                <!--                    </div>-->
                <!--                </article>-->
                <!---->
                <!--                <article class="row like">-->
                <!--                    <div class="col-md-2 col-sm-2 hidden-xs">-->
                <!--                        <figure class="thumbnail">-->
                <!--                            <img class="img-responsive" src="../IMG/big%20ramy.jpg"/>-->
                <!--                            <figcaption class="text-center">Big Ramy</figcaption>-->
                <!--                        </figure>-->
                <!--                    </div>-->
                <!--                </article>-->
                <!---->
                <!---->
                <!--                <article class="row like">-->
                <!--                    <div class="col-md-2 col-sm-2 hidden-xs">-->
                <!--                        <figure class="thumbnail">-->
                <!--                            <img class="img-responsive" src="../IMG/default.jpg"/>-->
                <!--                            <figcaption class="text-center">Tech Club</figcaption>-->
                <!--                        </figure>-->
                <!--                    </div>-->
                <!--                </article>-->
                <!---->
                <!--                <article class="row like">-->
                <!--                    <div class="col-md-2 col-sm-2 hidden-xs">-->
                <!--                        <figure class="thumbnail">-->
                <!--                            <img class="img-responsive" src="../IMG/default.jpg"/>-->
                <!--                            <figcaption class="text-center">Iten Khalid</figcaption>-->
                <!--                        </figure>-->
                <!--                    </div>-->
                <!--                </article>-->

            </section>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="chat-box">
        <div class="chat-head">
            <h3 id="chat-username">Ali Farouk</h3>
            <img src="https://maxcdn.icons8.com/windows10/PNG/16/Arrows/angle_down-16.png" title="Expand Arrow"
                 width="16">
        </div>
        <div class="chat-body">
            <div class="msg-insert" style="display: block; height: 320px; overflow: auto;"></div>
            <div class="chat-button">
                <input type="image" src="https://maxcdn.icons8.com/windows10/PNG/16/Arrows/angle_right-16.png"/>
            </div>
            <div class="chat-text">
                <textarea placeholder="Send"></textarea>
            </div>
        </div>
    </div>
</div>

</body>

</html>