<?php

session_start();
$email = $_POST["email"];

$pass = $_POST["pass"];

$servername = "localhost";

$username = "root";

$password = "password";

$db = "website";

$conn = mysqli_connect( $servername, $username, $password, $db );
if ( !$conn ) {

    die( "Connection failed: " . mysqli_connect_error() );

}

$sql = "SELECT * FROM `user` where email='$email' and password='$pass' ";
$result = mysqli_query( $conn, $sql );

if ( mysqli_num_rows( $result ) == 1 ) {
    $row = mysqli_fetch_assoc( $result );
    $_SESSION["email"] = $row["email"] ;
    $_SESSION["user_type"] = $row["user_type"];
    if ( $row['user_type'] == "company" ) {
        header( "location: company-profile.php" );
    } else if ( $row['user_type'] == "normal" ) {
        header( "location: normal-user-profile.php" );
    }

} else {

    echo "<script>
     alert('Wrong email or password ,Please try again');
     window.location.href='login-register.html';
     </script>";

}

mysqli_close( $conn );

?>