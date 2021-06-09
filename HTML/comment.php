<?php

if (isset($_POST['btn'])) {

    $postId = $_GET['post_id'];
    $email = $_GET['user_email'];
    $msg = $_POST['msg'];
    $date = date('Y-m-d');

    $servername = "localhost";
    $username = "root";
    $password = "password";
    $db = "website";

    $conn = mysqli_connect($servername, $username, $password, $db);
    if (!$conn) {

        die("Connection failed: " . mysqli_connect_error());

    }
    $sql = "INSERT INTO `post_comments` (`user_email`, `post_id`, `body`, `date`) VALUES ('$email', '$postId', '$msg', '$date');";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("location: home.php");
    }

}

?>