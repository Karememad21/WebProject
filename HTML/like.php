<?php


$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "website";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (isset($_POST['liked'])) {
    $post_id = $_POST["post_id"];
    $email = $_POST["user_email"];
    $result = mysqli_query($conn, "SELECT * FROM `post` WHERE id=$post_id");
    $row = mysqli_fetch_array($result);
    $n = $row["like_counter"];

    mysqli_query($conn, "UPDATE `post` SET `like_counter`=$n+1 WHERE id=$post_id");
    mysqli_query($conn, "INSERT INTO `post_likes`(`user_email`, `post_id`) VALUES ('$email',$post_id)");
    exit();

}
if (isset($_POST['unliked'])) {
    $post_id = $_POST["post_id"];
    $email = $_POST["user_email"];
    $result = mysqli_query($conn, "SELECT * FROM `post` WHERE id=$post_id");
    $row = mysqli_fetch_array($result);
    $n = $row["like_counter"];

    mysqli_query($conn, "UPDATE `post` SET `like_counter`=$n-1 WHERE id=$post_id");
    mysqli_query($conn, "DELETE FROM `post_likes` WHERE post_id=$post_id AND user_email='$email'");
    exit();

}
?>
<!---->
<!--<!DOCTYPE html>-->
<!--<html>-->
<!--<head>-->
<!--    <title>Like and Unlike</title>-->
<!--    <style type="text/css">-->
<!--        .content {-->
<!--            width: 50%;-->
<!--            margin: 100px auto;-->
<!--            border: 1px solid #cbcbcb;-->
<!--        }-->
<!---->
<!--        .posts {-->
<!--            width: 80%;-->
<!--            margin: 10px auto;-->
<!--            border: 1px solid #cbcbcb;-->
<!--            padding: 10px;-->
<!--        }-->
<!--    </style>-->
<!--</head>-->
<!--<body>-->
<!--<div class="content">-->
<!---->
<!---->
<!--    --><?php
//    $sql = "SELECT * FROM `post`";
//    $result = mysqli_query($conn, $sql);
//
//    while ($row = mysqli_fetch_array($result)) { ?>
<!---->
<!--        <div class="posts">-->
<!--            --><?php //echo $row['body']; ?><!-- <br>-->
<!---->
<!--            --><?php
//            $sql1 = "SELECT * FROM 'post_likes' WHERE user_email='nohanader570@gmail.com' AND post_id=" . $row['id'];
//            $result1 = mysqli_query($conn, $sql1);
//            if (mysqli_num_rows($result1) == 1) { ?>
<!---->
<!--                <span><a href='' class='unlike' id="--><?php //echo $row['id']; ?><!--">unLike</a></span>-->
<!---->
<!--            --><?php //} else { ?>
<!--                <span><a href='' class='like' id="--><?php //echo $row['id']; ?><!--">Like</a></span>-->
<!---->
<!--            --><?php //} ?>
<!---->
<!---->
<!--        </div>-->
<!--    --><?php //} ?>
<!---->
<!--</div>-->
<!---->
<!---->
<!--<script type="text/javascript" src="jquery-3.4.1.js"></script>-->
<!---->
<!--<script type="text/javascript">-->
<!---->
<!--    $(document).ready(function () {-->
<!---->
<!--        $('a.like').on('click', function () {-->
<!--            var post_id = $(this).attr('id');-->
<!---->
<!--            alert("Clicked Post ID: " + post_id);-->
<!--            $.ajax({-->
<!--                url: 'newFile.php',-->
<!--                type: 'post',-->
<!--                async: false,-->
<!--                data: {-->
<!--                    'liked': 1,-->
<!--                    'post_id': post_id-->
<!---->
<!--                },-->
<!--                success: function () {-->
<!---->
<!--                }-->
<!---->
<!---->
<!--            });-->
<!---->
<!--            $(this).addClass("unlike").removeClass("like");-->
<!--        });-->
<!---->
<!--        $('a.unlike').on('click', function () {-->
<!--            var post_id = $(this).attr('id');-->
<!---->
<!--            $.ajax({-->
<!--                url: 'newFile.php',-->
<!--                type: 'post',-->
<!--                async: false,-->
<!--                data: {-->
<!--                    'unliked': 1,-->
<!--                    'post_id': post_id-->
<!---->
<!--                },-->
<!--                success: function () {-->
<!---->
<!--                }-->
<!--            });-->
<!--            $(this).addClass("like").removeClass("unlike");-->
<!--            // $(this).removeClass("like");-->
<!--            // $(this).addClass("unlike");-->
<!--            // $(this).attr('class', "unlike");-->
<!---->
<!--            //var requiredID="#" + $(this).attr('id');-->
<!--            // $(requiredID).attr('class')="like";-->
<!--            // alert("req ID: " + requiredID);-->
<!---->
<!---->
<!--        });-->
<!---->
<!---->
<!--    });-->
<!--</script>-->
<!--</body>-->
<!--</html>-->
