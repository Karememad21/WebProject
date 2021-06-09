<?php

$servername = "localhost";
$username = "root";
$password = "password";
$db = "website";

$conn = mysqli_connect($servername, $username, $password, $db);

function is_liked($post_id, $email)
{
    global $conn;
    $sql = "SELECT * FROM `post_likes` WHERE post_id='$post_id' AND user_email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else return false;
}

function is_company_liked($email, $company)
{
    global $conn;
    $sql = "SELECT * FROM `company_liker` WHERE company_email='$company' AND liker_email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else return false;
}

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
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../CSS/home.css">

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
                <li><a href="../HTML/messages.php">Messages</a></li>
                <li><a href="../HTML/login-register.html">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container" style="width: 740px;">
    <div class="row">
        <div class="col-md-8">
            <h2 class="page-header">Posts</h2>
            <section class="comment-list">
                <article class="row post">
                    <div class="col-md-2 col-sm-2 hidden-xs">
                        <figure class="thumbnail">

                            <?php $image = $row['profile_picture'];
                            echo "<img src='../IMG/$image' class='img-responsive' />";
                            ?>
                            <figcaption class="text-center"><?php echo $row['name'];
                                ?></figcaption>
                        </figure>
                    </div>
                    <div class="col-md-10 col-sm-10">
                        <div class="panel panel-default arrow left">
                            <div class="panel-body">
                                <header class="text-left">
                                    <div class="comment-post">
                                        <form method="post" <?php echo "action='getPostHome.php?user_email=$email' ";
                                        ?> enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label for="textarea" class="col-12 col-form-label">Write your post
                                                    here</label>
                                                <div class="col-12">
                                                    <textarea id="textarea" name="msg" cols="50" rows="3"
                                                              class="form-control"></textarea>
                                                </div>
                                            </div>

                                    </div>
                                    <div style="margin-left: 15px;">
                                        <button class="btn btn-primary" name="btn" style="display: inline-block;">
                                            <strong>post</strong></button>
                                        <input type="file" class="btn btn-primary" name="my_image"
                                               style="display: inline-block;" value="Upload Picture">
                                    </div>
                                    </form>
                                </header>
                            </div>
                        </div>
                    </div>
                </article>

                <?php
                foreach ($posts as $post) {
                    $user = getUser($post['owner_email']);
                    echo('
                <article class="row post">
                        <div class="col-md-2 col-sm-2 hidden-xs">
                            <figure class="thumbnail">
                                <img class="img-responsive" src="' . '..\IMG\\' . $user['profile_picture'] . '" />
                                <figcaption class="text-center">' . $user['name'] . '</figcaption>
                            </figure>
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <div class="panel panel-default arrow left">
                                <div class="panel-body">
                                    <div>
                                        <header class="text-left">
                                            <time class="comment-date" datetime="16-12-2014 01:05"> Dec 16, 2014</time>');
                                        if($user['user_type'] == 'company' && $user['email'] != $email)
                                            if(is_company_liked($email, $user['email']))
                                                echo '<button class="btn btn-primary like like-company" onclick="likeCompany( event, \'' . $email . '\', \'' . $user['email'] . '\' )"> <strong>like Page</strong></button>';
                                            else
                                                echo '<button class="btn btn-primary like liked like-company" onclick="likeCompany( event, \'' . $email . '\', \'' . $user['email'] . '\' )"> <strong>like Page</strong></button>';
                                        echo '
                                    </header>
                                    </div>
                                    <div class="comment-post">
                                        <p class="fas fa-user-circle">' . $post['body'] . '</p>';
                    if ($post['image'] != '')
                        echo('<img class="img" src="../IMG/' . $post['image'] . '" class="img-fluid" alt="Responsive image">');
                    if (is_liked($post['id'], $email))
                        $liked = "true";
                    else $liked = "false";
                    echo("<script> console.log('$liked'); </script>");
                    echo('
                                    </div>
                                    <p class="like-counter" style="display: inline-block !important;">' . $post['like_counter'] . '</p>
                                    <button class="btn btn-primary like ');
                    if ($liked == "false")
                        echo('liked');
                    echo('" onclick="setColor( event, ' . $post['id'] . ', \'' . $email . '\', \'' . $post['owner_email'] . '\' )"> <strong>like</strong></button>
                                    <button class="btn btn-primary" onclick="commentBtnClicked( event, ' . $post['id'] . ', \'' . $email . '\', \'' . $post['owner_email'] . '\' )"><strong>Comment</strong></button>
                                    <section class=\'comments-section\'>');

                    $post_id = $post['id'];
                    $sqlcomment = "SELECT * FROM `post_comments` where `post_id`=$post_id";
                    $resultcomment = mysqli_query($conn, $sqlcomment);
                    for ($j = 0; $j < mysqli_num_rows($resultcomment); $j++) {
                        $rowcomment = mysqli_fetch_assoc($resultcomment);
                        $useremail = $rowcomment['user_email'];
                        $sql = "SELECT * FROM `user` where email='$useremail'";
                        $result = mysqli_query($conn, $sql);
                        $rowuser = mysqli_fetch_assoc($result);

                        echo "
                            <article class='row comment'>
                                <div class='col-md-2 col-sm-2 hidden-xs'>
                                    <figure class='thumbnail'> <img class='img-responsive' src='../IMG/" . $rowuser['profile_picture'] . "'" . " />
                                        <figcaption class='text-center'>" . $rowuser['name'] . "</figcaption>
                                    </figure>
                                </div>
                                <div class='col-md-10 col-sm-10'>
                                    <div class='panel panel-default arrow left'>
                                        <div class='panel-body'>
                                            <header class='text-left'> <time class='comment-date' datetime=''>" . $rowcomment['date'] . "</time> </header>
                                            <div class='comment-post'>
                                                <p>" . $rowcomment['body'] . "</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>";
                    }
                    echo "
                        <article class='row'>
                            <div class='col-md-2 col-sm-2 hidden-xs'>
                                <figure class='thumbnail'> <img class='img-responsive' src='../IMG/" . $image . "'" . " />
                                    <figcaption class='text-center'>" . $row['name'] . "</figcaption>
                                </figure>
                            </div>
                            <div class='col-md-10 col-sm-10'>
                                <div class='panel panel-default arrow left'>
                                    <div class='panel-body'>
                                        <header class='text-left'>
                                            <div class='comment-post'>
                                                <form method='post' action='comment.php?post_id=$post_id && user_email=$email'>
                                                    <div class='form-group row'> <label for='commenttextarea' class='col-8 col-form-label'>Write Your Comment Here</label>
                                                        <div class='col-8'> <textarea id='msg' name='msg' cols='50' rows='3' class='form-control'></textarea>
                                                        </div>
                                                    </div>                                
                                                    <button name='btn' class='btn btn-primary'> <strong>post</strong></button>
                                                </form>
                                            </div> 
                                        </header>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </section>
            
            
                </div>
            </div>
            </div>
                                        
            </article>";
//                                    <section class="comments-section">
//                                        <article class="row comment">
//                                            <div class="col-md-2 col-sm-2 hidden-xs">
//                                                <figure class="thumbnail"> <img class="img-responsive" src="../IMG/default.jpg" />
//                                                    <figcaption class="text-center">Iten Khalid</figcaption>
//                                                </figure>
//                                            </div>
//                                            <div class="col-md-10 col-sm-10">
//                                                <div class="panel panel-default arrow left">
//                                                    <div class="panel-body">
//                                                        <header class="text-left"> <time class="comment-date" datetime="10-12-2017 01:05"> Dec 10, 2017</time> </header>
//                                                        <div class="comment-post">
//                                                            <p>nice work!</p>
//                                                        </div>
//                                                    </div>
//                                                </div>
//                                            </div>
//                                        </article>
//                                        <article class="row">
//                                            <div class="col-md-2 col-sm-2 hidden-xs">
//                                                <figure class="thumbnail"> <img class="img-responsive" src="../IMG/company-profile-img1.jpeg" />
//                                                    <figcaption class="text-center">ByteInc</figcaption>
//                                                </figure>
//                                            </div>
//                                            <div class="col-md-10 col-sm-10">
//                                                <div class="panel panel-default arrow left">
//                                                    <div class="panel-body">
//                                                        <header class="text-left">
//                                                            <div class="comment-post">
//                                                                <form>
//                                                                    <div class="form-group row"> <label for="commenttextarea" class="col-8 col-form-label">Write Your Comment Here</label>
//                                                                        <div class="col-8"> <textarea id="commenttextarea" name="commenttextarea" cols="50" rows="3" class="form-control"></textarea> </div>
//                                                                    </div>
//                                                                </form>
//                                                            </div> <button class="btn btn-primary"> <strong>post</strong></button>
//                                                        </header>
//                                                    </div>
//                                                </div>
//                                            </div>
//                                        </article>
//                                    </section>
//                                </div>
//                            </div>
//                        </div>
//                    </article>');
                }
                ?>
                <!-- First Comment -->
                <!--
<article class = "row post">
<div class = "col-md-2 col-sm-2 hidden-xs">
<figure class = "thumbnail">
<img class = "img-responsive" src = "../IMG/undertaker.jpg" />
<figcaption class = "text-center">Ali Farouk</figcaption>
</figure>
</div>
<div class = "col-md-10 col-sm-10">
<div class = "panel panel-default arrow left">
<div class = "panel-body">
<div>
<header class = "text-left">

<time class = "comment-date" datetime = "16-12-2014 01:05"> Dec 16, 2014</time>
<button class = "btn btn-primary like like-company" onclick = "setColor(event)"> <strong>like Page</strong></button>
</header>
</div>
<div class = "comment-post">
<p class = "fas fa-user-circle">Ali Farouk changed his profile picture</p>
<img class = "img" src = "../IMG/undertaker.jpg" class = "img-fluid" alt = "Responsive image">
</div>
<p style = "display: inline-block !important;">13k</p>
<button class = "btn btn-primary like" onclick = "setColor(event)"> <strong>like</strong></button>
<button class = "btn btn-primary" onclick = "commentBtnClicked(event)"><strong>Comment</strong></button>
<section class = "comments-section">
<article class = "row comment">
<div class = "col-md-2 col-sm-2 hidden-xs">
<figure class = "thumbnail"> <img class = "img-responsive" src = "../IMG/default.jpg" />
<figcaption class = "text-center">Iten Khalid</figcaption>
</figure>
</div>
<div class = "col-md-10 col-sm-10">
<div class = "panel panel-default arrow left">
<div class = "panel-body">
<header class = "text-left"> <time class = "comment-date" datetime = "10-12-2017 01:05"> Dec 10, 2017</time> </header>
<div class = "comment-post">
<p>nice work!</p>
</div>
</div>
</div>
</div>
</article>
<article class = "row">
<div class = "col-md-2 col-sm-2 hidden-xs">
<figure class = "thumbnail"> <img class = "img-responsive" src = "../IMG/company-profile-img1.jpeg" />
<figcaption class = "text-center">ByteInc</figcaption>
</figure>
</div>
<div class = "col-md-10 col-sm-10">
<div class = "panel panel-default arrow left">
<div class = "panel-body">
<header class = "text-left">
<div class = "comment-post">
<form>
<div class = "form-group row"> <label for = "commenttextarea" class = "col-8 col-form-label">Write Your Comment Here</label>
<div class = "col-8"> <textarea id = "commenttextarea" name = "commenttextarea" cols = "50" rows = "3" class = "form-control"></textarea> </div>
</div>
</form>
</div> <button class = "btn btn-primary"> <strong>post</strong></button>
</header>
</div>
</div>
</div>
</article>
</section>
</div>
</div>
</div>
</article>

<article class = "row post">
<div class = "col-md-2 col-sm-2 hidden-xs">
<figure class = "thumbnail">
<img class = "img-responsive" src = "../IMG/big%20ramy.jpg" />
<figcaption class = "text-center">Big Ramy</figcaption>
</figure>
</div>
<div class = "col-md-10 col-sm-10">
<div class = "panel panel-default arrow left">
<div class = "panel-body">
<header class = "text-left">

<time class = "comment-date" datetime = "16-12-2014 01:05"> Dec 16, 2014</time>
</header>
<div class = "comment-post">
<p>Winter is Coming</p>
<img class = "img" src = "../IMG/big%20ramy.jpg" class = "img-fluid" alt = "Responsive image">
<br>
</div>
<p style = "display: inline-block !important;">13k</p>
<button class = "btn btn-primary like" onclick = "setColor(event)"> <strong>like</strong></button>
<button class = "btn btn-primary" onclick = "commentBtnClicked(event)"><strong>Comment</strong></button>
<section class = "comments-section">
<article class = "row comment">
<div class = "col-md-2 col-sm-2 hidden-xs">
<figure class = "thumbnail"> <img class = "img-responsive" src = "../IMG/default.jpg" />
<figcaption class = "text-center">Iten Khalid</figcaption>
</figure>
</div>
<div class = "col-md-10 col-sm-10">
<div class = "panel panel-default arrow left">
<div class = "panel-body">
<header class = "text-left"> <time class = "comment-date" datetime = "10-12-2017 01:05"> Dec 10, 2017</time> </header>
<div class = "comment-post">
<p>nice work!</p>
</div>
</div>
</div>
</div>
</article>
<article class = "row">
<div class = "col-md-2 col-sm-2 hidden-xs">
<figure class = "thumbnail"> <img class = "img-responsive" src = "../IMG/company-profile-img1.jpeg" />
<figcaption class = "text-center">ByteInc</figcaption>
</figure>
</div>
<div class = "col-md-10 col-sm-10">
<div class = "panel panel-default arrow left">
<div class = "panel-body">
<header class = "text-left">
<div class = "comment-post">
<form>
<div class = "form-group row"> <label for = "commenttextarea" class = "col-8 col-form-label">Write Your Comment Here</label>
<div class = "col-8"> <textarea id = "commenttextarea" name = "commenttextarea" cols = "50" rows = "3" class = "form-control"></textarea> </div>
</div>
</form>
</div> <button class = "btn btn-primary"> <strong>post</strong></button>
</header>
</div>
</div>
</div>
</article>
</section>
</div>
</div>
</div>
</article>

<article class = "row post">
<div class = "col-md-2 col-sm-2 hidden-xs">
<figure class = "thumbnail">
<img class = "img-responsive" src = "../IMG/default.jpg" />
<figcaption class = "text-center">Tech Club</figcaption>
</figure>
</div>
<div class = "col-md-10 col-sm-10">
<div class = "panel panel-default arrow left">
<div class = "panel-body">
<header class = "text-left">

<time class = "comment-date" datetime = "16-12-2014 01:05"> Dec 16, 2014</time>
</header>
<div class = "comment-post">
<p>شركة فيسبوك عاملة حركة إعلانية غريبةلو بحثت عن تطبيق Signal، يظهر لك تطبيق Messenger، ودا طبعًا بسبب إن معظم الناس سابت WhatsApp ونزلت signal بعد آخر تحديث!</p>
</div>
<p style = "display: inline-block !important;">13k</p>
<button class = "btn btn-primary like" onclick = "setColor(event)"> <strong>like</strong></button>
<button class = "btn btn-primary" onclick = "commentBtnClicked(event)"><strong>Comment</strong></button>
<section class = "comments-section">
<article class = "row comment">
<div class = "col-md-2 col-sm-2 hidden-xs">
<figure class = "thumbnail"> <img class = "img-responsive" src = "../IMG/default.jpg" />
<figcaption class = "text-center">Iten Khalid</figcaption>
</figure>
</div>
<div class = "col-md-10 col-sm-10">
<div class = "panel panel-default arrow left">
<div class = "panel-body">
<header class = "text-left"> <time class = "comment-date" datetime = "10-12-2017 01:05"> Dec 10, 2017</time> </header>
<div class = "comment-post">
<p>nice work!</p>
</div>
</div>
</div>
</div>
</article>
<article class = "row">
<div class = "col-md-2 col-sm-2 hidden-xs">
<figure class = "thumbnail"> <img class = "img-responsive" src = "../IMG/company-profile-img1.jpeg" />
<figcaption class = "text-center">ByteInc</figcaption>
</figure>
</div>
<div class = "col-md-10 col-sm-10">
<div class = "panel panel-default arrow left">
<div class = "panel-body">
<header class = "text-left">
<div class = "comment-post">
<form>
<div class = "form-group row"> <label for = "commenttextarea" class = "col-8 col-form-label">Write Your Comment Here</label>
<div class = "col-8"> <textarea id = "commenttextarea" name = "commenttextarea" cols = "50" rows = "3" class = "form-control"></textarea> </div>
</div>
</form>
</div> <button class = "btn btn-primary"> <strong>post</strong></button>
</header>
</div>
</div>
</div>
</article>
</section>
</div>
</div>
</div>
</article>

<article class = "row post">
<div class = "col-md-2 col-sm-2 hidden-xs">
<figure class = "thumbnail">
<img class = "img-responsive" src = "../IMG/default.jpg" />
<figcaption class = "text-center">Iten Khalid</figcaption>
</figure>
</div>
<div class = "col-md-10 col-sm-10">
<div class = "panel panel-default arrow left">
<div class = "panel-body">
<header class = "text-left">

<time class = "comment-date" datetime = "16-12-2014 01:05"> Dec 16, 2014</time>
</header>
<div class = "comment-post">
<p>Iten Khalid Shared</p>
<img class = "img" src = "../IMG/ahly.jpg" class = "img-fluid" alt = "Responsive image">
</div>
<p style = "display: inline-block !important;">13k</p>
<button class = "btn btn-primary like" onclick = "setColor(event)"> <strong>like</strong></button>
<button class = "btn btn-primary" onclick = "commentBtnClicked(event)"><strong>Comment</strong></button>
<section class = "comments-section">
<article class = "row comment">
<div class = "col-md-2 col-sm-2 hidden-xs">
<figure class = "thumbnail"> <img class = "img-responsive" src = "../IMG/default.jpg" />
<figcaption class = "text-center">Iten Khalid</figcaption>
</figure>
</div>
<div class = "col-md-10 col-sm-10">
<div class = "panel panel-default arrow left">
<div class = "panel-body">
<header class = "text-left"> <time class = "comment-date" datetime = "10-12-2017 01:05"> Dec 10, 2017</time> </header>
<div class = "comment-post">
<p>nice work!</p>
</div>
</div>
</div>
</div>
</article>
<article class = "row">
<div class = "col-md-2 col-sm-2 hidden-xs">
<figure class = "thumbnail"> <img class = "img-responsive" src = "../IMG/company-profile-img1.jpeg" />
<figcaption class = "text-center">ByteInc</figcaption>
</figure>
</div>
<div class = "col-md-10 col-sm-10">
<div class = "panel panel-default arrow left">
<div class = "panel-body">
<header class = "text-left">
<div class = "comment-post">
<form>
<div class = "form-group row"> <label for = "commenttextarea" class = "col-8 col-form-label">Write Your Comment Here</label>
<div class = "col-8"> <textarea id = "commenttextarea" name = "commenttextarea" cols = "50" rows = "3" class = "form-control"></textarea> </div>
</div>
</form>
</div> <button class = "btn btn-primary"> <strong>post</strong></button>
</header>
</div>
</div>
</div>
</article>
</section>
</div>
</div>
</div>
</article>

</section>
</div>
</div>
</div>
-->

                <div class="wrapper">
                    <div class="chat-box">
                        <div class="chat-head">
                            <h3 id="chat-username">iten khalid</h3>
                            <img src="https://maxcdn.icons8.com/windows10/PNG/16/Arrows/angle_down-16.png"
                                 title="Expand Arrow" width="16">
                        </div>
                        <div class="chat-body">
                            <div class="msg-insert" style="display: block; height: 320px; overflow: auto;"></div>
                            <div class="chat-button">
                                <input type="image"
                                       src="https://maxcdn.icons8.com/windows10/PNG/16/Arrows/angle_right-16.png"/>
                            </div>
                            <div class="chat-text">
                                <textarea placeholder="Send"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

</body>

</html>
