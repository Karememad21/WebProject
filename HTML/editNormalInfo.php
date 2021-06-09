<?php 

 SESSION_START();

if(isset($_SESSION["email"]))
{
if(isset($_POST['btn']))
{
  $name = $_POST['name'];
  $email =$_POST['email'];
  $pass = $_POST['password'];
  $bio =$_POST['bio'];
  $skills = $_POST['skills'];
  $info= $_POST['info'];
  
  /*echo $name;
  echo $email ;*/
  
  
  
  
  $servername = "localhost";

  $username = "root";

  $password = "password";

  $db = "website";

  $conn = mysqli_connect($servername, $username, $password,$db);

  if (!$conn) {

   die("Connection failed: " . mysqli_connect_error());

   }
     
	 $sql2 ="SELECT * FROM `normal_user` where normal_email='$email' " ;
	 $result2 = mysqli_query($conn, $sql2);
	 if(mysqli_num_rows($result2) ==0)
       {
	     $sqlempty ="INSERT INTO `normal_user` (`normal_email`, `bio`, `info`, `skills`) VALUES ('$email', '$bio', '$info', '$skills')";
		 $resultempty = mysqli_query($conn,$sqlempty);
	   }
	 else
	 {
		 $sqlInfo ="UPDATE `normal_user` SET `bio` = '$bio',`info`='$info' ,`skills` = '$skills' WHERE `normal_user`.`normal_email` = '$email'" ;
		 $resultInfo = mysqli_query($conn,$sqlInfo);
	 }
	     
		 
		  
		    $img_name = $_FILES['my_image']['name'];
            $img_size = $_FILES['my_image']['size'];
            $tmp_name = $_FILES['my_image']['tmp_name'];
            $error = $_FILES['my_image']['error'];
		   if($error == 0)
	           { 
			    $img_ex = pathinfo($img_name,PATHINFO_EXTENSION);
			    $img_ex_lc = strtolower($img_ex);
			    $allowed_exs = array("jpg","jpeg","png");
				
				if(in_array($img_ex_lc,$allowed_exs))
		     	{
	 	            $new_img_name = uniqid("IMG-",true).'.'.$img_ex_lc ;
				    $img_upload_path = '../IMG/'.$new_img_name ;
				    move_uploaded_file($tmp_name,$img_upload_path);
		            $sqll = "UPDATE `user` SET  `profile_picture`='$new_img_name' ,`password` = '$pass' , `name`='$name' WHERE `user`.`email` = '$email' ";
                    $resultt = mysqli_query($conn, $sqll);
         
                   if($resultt || $resultInfo )
                     {
      	              header("location: normal-user-profile.php?user_email=$email");
                      }
                }
				else
				{
					echo "<script>
                    alert('you can not upload this type of file');
                    window.location.href='edit-normal-user-profile.php?user_email=$email';
                    </script>";
                    
					
				}
                 mysqli_close($conn);
	 
			   }
			   else
			   {
				   $sqll = "UPDATE `user` SET `password` = '$pass' , `name`='$name' WHERE `user`.`email` = '$email' ";
                    $resultt = mysqli_query($conn, $sqll);
         
                   if($resultt || $resultInfo )
                     {
      	              header("location: normal-user-profile.php?user_email=$email");
                     }
			   }
         
 }

}
else
{
	header("location: login-register.html");
}









?>