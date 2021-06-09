<?php


$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "website";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (isset($_POST['liked'])) {
    $liker_email = $_POST["liker_email"];
    $company_email = $_POST["company_email"];

    mysqli_query($conn, "INSERT INTO `company_liker`(`liker_email`, `company_email`) VALUES ('$liker_email','$company_email')");
    exit();
}
if (isset($_POST['unliked'])) {
    $liker_email = $_POST["liker_email"];
    $company_email = $_POST["company_email"];

    mysqli_query($conn, "DELETE FROM `company_liker` WHERE liker_email='$liker_email' AND company_email='$company_email'");
    exit();
}
?>