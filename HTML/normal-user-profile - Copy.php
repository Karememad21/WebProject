<?php

SESSION_START();

if (isset($_SESSION["email"])) {

    $email = $_GET['user_email'];
    $servername = "localhost";
    $username = "root";
    $password = "12345678";
    $db = "website";

    $conn = mysqli_connect($servername, $username, $password, $db);
    if (!$conn) {

        die("Connection failed: " . mysqli_connect_error());

    }

    $sql = "SELECT * FROM `user` where email='$email'";
    $sqltem = "SELECT * FROM `normal_user` where normal_email='$email'";
    $result = mysqli_query($conn, $sql);
    $resulttem = mysqli_query($conn, $sqltem);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

    }
    if (mysqli_num_rows($resulttem) == 1) {
        $roww = mysqli_fetch_assoc($resulttem);


    }

    $sqltext = "SELECT id,body,image FROM `post` WHERE `owner_email` ='$email'";
    $resulttext = mysqli_query($conn, $sqltext);

//$sqlcomment="SELECT * FROM `post_comments`";
//$resultcomment= mysqli_query($conn,$sqlcomment);

} else {
    header("location: login-register.html");
}


?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../CSS/normal-user-profile.css">

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
            <a href="#" class="navbar-brand"> Profile</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-nav-demo">

            <ul class="nav navbar-nav navbar-right">
                <li><a href="../HTML/home.html">Home</a></li>
                <li><?php echo "<a href='edit-normal-user-profile.php?user_email=$email'>Edit Profile</a>" ?></li>
                <li><a href="../HTML/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>


<div class="container profilepanel" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="row panel">
        <div class="col-md-4 bg_blur ">
        </div>
        <div class="col-md-8  col-xs-12">
            <?php

            $image = $row['profile_picture'];
            echo "<img src='../IMG/$image' class='img-thumbnail picture hidden-xs' />";
            ?>
            <img src="../IMG/normal-user-profile-img2.jfif" class="img-thumbnail visible-xs picture_mob"/>
            <div class="header">
                <h1><?php echo $row['name']; ?></h1>

                <?php $arr = explode(",", $roww['bio']);

                for ($i = 0; $i < count($arr); $i++) {
                    echo "<span>" . $arr[$i] . "</span>";
                    echo "<br>";
                }
                ?>

            </div>
        </div>
    </div>
</div>


<div class="container-fluid left-panel">
    <div class="row">
        <div class="col-md-2 col-sm-4 sidebar1">

            <br>
            <div class="left-navigation">
                <ul class="list">
                    <h5><strong>Info</strong></h5>
                    <?php $arr = explode(",", $roww['info']);

                    for ($i = 0; $i < count($arr); $i++)
                        echo "<li>" . $arr[$i] . "</li>";

                    ?>

                </ul>

                <br>

                <ul class="list">
                    <h5><strong>Skills</strong></h5>
                    <?php $arr = explode(",", $roww['skills']);

                    for ($i = 0; $i < count($arr); $i++)
                        echo "<li>" . $arr[$i] . "</li>";

                    ?>
                </ul>
            </div>
        </div>
        <div class="col-md-10 col-sm-8 main-content">


            <div class="container">
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
                                        <figcaption class="text-center"><?php echo $row['name']; ?></figcaption>
                                    </figure>
                                </div>
                                <div class="col-md-10 col-sm-10">
                                    <div class="panel panel-default arrow left">
                                        <div class="panel-body">
                                            <header class="text-left">
                                                <div class="comment-post">
                                                    <form method="post" <?php echo "action='getPost.php?user_email=$email' "; ?>
                                                          enctype="multipart/form-data">
                                                        <div class="form-group row">
                                                            <label for="textarea" class="col-12 col-form-label">Write
                                                                your post here</label>
                                                            <div class="col-12">
                                                                <textarea id="textarea" name="msg" cols="50" rows="3"
                                                                          class="form-control"></textarea>
                                                            </div>
                                                        </div>

                                                </div>
                                                <div style="margin-left: 15px;">
                                                    <button class="btn btn-primary" name="btn"
                                                            style="display: inline-block;"><strong>post</strong>
                                                    </button>
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

                            $image = $row['profile_picture'];

                            for ($i = 0; $i < mysqli_num_rows($resulttext); $i = $i + 1) {
                                $rowtext = mysqli_fetch_assoc($resulttext);
                                $postid = $rowtext['id'];

                                if ($rowtext['body'] != "") {
                                    echo " <article class='row post'>
                                    <div class='col-md-2 col-sm-2 hidden-xs'>
                                        <figure class='thumbnail'>" . "<img src='../IMG/" . $image . "'" . "class='img-responsive' />
				                               
                                      <figcaption class='text-center'>" . $row['name'] . "</figcaption>
                                        </figure>
                                    </div>
                                    <div class='col-md-10 col-sm-10'>
                                        <div class='panel panel-default arrow left'>
                                            <div class='panel-body'>
                                                <header class='text-left'>

                                                    <time class='comment-date' datetime=''>" . date('M d, Y') . "</time>
                                                </header>
                                                <div class='comment-post'>" .

                                        "<p>" . $rowtext['body'] . "</p>" . "
															  
                                                    
                                                </div>
												<p style='display: inline-block !important;'>13k</p> <button class='btn btn-primary like' onclick='setColor(event)'> <strong>like</strong></button>
                                                <button class='btn btn-primary' onclick='commentBtnClicked(event)'><strong>Comment</strong></button>
                                                <section class='comments-section'>";
                                    $sqlcomment = "SELECT * FROM `post_comments` where `post_id`=$postid";
                                    $resultcomment = mysqli_query($conn, $sqlcomment);
                                    for ($j = 0; $j < mysqli_num_rows($resultcomment); $j++) {
                                        $rowcomment = mysqli_fetch_assoc($resultcomment);
                                        $useremail = $rowcomment['user_email'];
                                        $sql = "SELECT * FROM `user` where email='$useremail'";
                                        $result = mysqli_query($conn, $sql);
                                        $rowuser = mysqli_fetch_assoc($result);

                                        echo "<article class='row comment'>
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
                                    echo " <article class='row'>
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
                                                                            <form method='post' action='comment.php?post_id=$postid && user_email=$email'>
                                                                                <div class='form-group row'> <label for='commenttextarea' class='col-8 col-form-label'>Write Your Comment Here</label>
                                                                                    <div class='col-8'> <textarea id='msg' name='msg' cols='50' rows='3' class='form-control'></textarea> </div>
                                                                                </div>
                                                                            
                                                                        </div> <button name='btn' class='btn btn-primary'> <strong>post</strong></button>
																		</form>
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
                                } else {

                                    echo " <article class='row post'>
                                    <div class='col-md-2 col-sm-2 hidden-xs'>
                                        <figure class='thumbnail'>" . "<img src='../IMG/" . $image . "'" . "class='img-responsive' />
				                               
                                      <figcaption class='text-center'>" . $row['name'] . "</figcaption>
                                        </figure>
                                    </div>
                                    <div class='col-md-10 col-sm-10'>
                                        <div class='panel panel-default arrow left'>
                                            <div class='panel-body'>
                                                <header class='text-left'>

                                                    <time class='comment-date' datetime=''>" . date('M d, Y') . "</time>
                                                </header>
                                                <div class='comment-post'>" .

                                        "<img class='img' src='../IMG/" . $rowtext['image'] . "'" . " class='img-fluid' alt='Responsive image'>
															  
                                                    
                                                </div>
												<p style='display: inline-block !important;'>13k</p> <button class='btn btn-primary like' onclick='setColor(event)'> <strong>like</strong></button>
                                                <button class='btn btn-primary' onclick='commentBtnClicked(event)'><strong>Comment</strong></button>
                                                <section class='comments-section'>";
                                    $sqlcomment = "SELECT * FROM `post_comments` where `post_id`=$postid";
                                    $resultcomment = mysqli_query($conn, $sqlcomment);
                                    for ($j = 0; $j < mysqli_num_rows($resultcomment); $j++) {
                                        $rowcomment = mysqli_fetch_assoc($resultcomment);
                                        $useremail = $rowcomment['user_email'];
                                        $sql = "SELECT * FROM `user` where email='$useremail'";
                                        $result = mysqli_query($conn, $sql);
                                        $rowuser = mysqli_fetch_assoc($result);

                                        echo "<article class='row comment'>
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

                                    echo " <article class='row'>
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
                                                                            <form method='post' action='comment.php?post_id=$postid && user_email=$email'>
                                                                                <div class='form-group row'> <label for='commenttextarea' class='col-8 col-form-label'>Write Your Comment Here</label>
                                                                                    <div class='col-8'> <textarea id='msg' name='msg' cols='50' rows='3' class='form-control'></textarea> </div>
                                                                                </div>
                                                                            
                                                                        </div> <button name='btn' class='btn btn-primary'> <strong>post</strong></button>
																		</form>
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


                                }
                            }
                            ?>

</body>
</html>
