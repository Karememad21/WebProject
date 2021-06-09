

<?php

SESSION_START();

if(isset($_SESSION["email"]))
{

$email = $_SESSION['email'];

$servername = "localhost";
$username = "root";
$password = "password";
$db = "website";

$conn = mysqli_connect($servername, $username, $password,$db);
if (!$conn) {

   die("Connection failed: " . mysqli_connect_error());

}

$sql = "SELECT * FROM `user` where email='$email'";
$sql2 ="SELECT * FROM `normal_user` where normal_email='$email' " ;
$result = mysqli_query($conn, $sql);
$result2 = mysqli_query($conn, $sql2);

 if(mysqli_num_rows($result) ==1)
 {
  $row = mysqli_fetch_assoc($result);
  
 
}

if(mysqli_num_rows($result2) ==1)
 {
  $row2 = mysqli_fetch_assoc($result2);
  
 
}

}
else
{
	header("location: login-register.html");
}

?>


<html>

<head>
    <link rel="stylesheet" href="../CSS/edit-normal-user-profile.css"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="../JS/edit-normal-user-profile.js"></script>
</head> 

<body>

    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="editNormalInfo.php" method="post" enctype="multipart/form-data">
                <h1>Update Info</h1>
                <input type="text" placeholder="Name" name="name" id="name" value="<?php echo $row['name'];?>" />
                <input type="email" placeholder="Email" name="email" id="email" value="<?php echo $row['email'];?>"/>
				<input type="password" placeholder="Password"  name="password" id="password" value="<?php echo $row['password'];?>" />
                <input type="Bio" placeholder="Bio" name="bio" id="bio" value="<?php echo $row2['bio'];?>" />
                <input type="info" placeholder="info" name="info" id="info" value="<?php echo $row2['info'];?>" />
                <input type="skills" name="skills" id="skills" value="<?php echo $row2['skills'];?>" placeholder="write you skills seperated by a comma" />
                Upload Picture: <input type="file" name="my_image" id="my_image" class="btn btn-info" value="Upload Picture">
                <button type="submit" name="btn" id="btn" >Update my info</button>
            </form>
        </div>

        <div class="form-container sign-in-container">
            <form action="#">
                <h1>Update Account</h1>
<!--                <img src="../IMG/normal-user-profile-img1.jfif" class="img-thumbnail rounded mx-auto d-block profile" />-->
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left"> 
                    <h1>Go back to your profile</h1>
                    <button><?php echo"<a href='normal-user-profile.php?user_email=$email'>go Back</a>" ?></button>
                </div>
				<!-- <a href=../HTML/normal-user-profile.php?user_email=ayten@gmail.com">go Back</a>-->
                <div class="overlay-panel overlay-right">
                    <h3>Changing your info?</h3>

                    <button class="ghost" id="updateinfo">Update info</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>


