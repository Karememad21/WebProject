
<?php 
$name =$_POST['username'];
$email =$_POST['uemail'];
$pass =$_POST['password'];
$date =$_POST['date'];
$user_type=$_POST['user-type'] ;

if(isset($_POST['btn']) && isset($_FILES['my_image']))
{

$servername = "localhost";

$username = "root";

$password = "password";

$db = "website";

$conn = mysqli_connect($servername, $username, $password,$db);

if (!$conn) {

   die("Connection failed: " . mysqli_connect_error());

 }

  $img_name = $_FILES['my_image']['name'];
  $img_size = $_FILES['my_image']['size'];
  $tmp_name = $_FILES['my_image']['tmp_name'];
  $error = $_FILES['my_image']['error'];
	 
	 if($error == 0)
	 { 
	    if($img_size > 12500000)
		{
			echo "<script>
                 alert('sorry, your file is too large !');
                 window.location.href='login-register.html';
                 </script>";
			
		}
		else 
		{
			$img_ex = pathinfo($img_name,PATHINFO_EXTENSION);
			$img_ex_lc = strtolower($img_ex);
			$allowed_exs = array("jpg","jpeg","png");
			if(in_array($img_ex_lc,$allowed_exs))
			{
				$new_img_name = uniqid("IMG-",true).'.'.$img_ex_lc ;
				$img_upload_path = '../IMG/'.$new_img_name ;
				move_uploaded_file($tmp_name,$img_upload_path);
				$sql = "INSERT INTO `user`(`email`, `password`, `name`, `dob`, `profile_picture`,`user_type`) VALUES ('$email','$pass','$name','$date','$new_img_name','$user_type')";
                $result = mysqli_query($conn, $sql);
               if($result)
                  {
                  	header("location: home.php");
                   }

               else
                  {
	                echo "<script>
                    alert('This Email Already Exits,Try another email ');
                    window.location.href='login-register.html';
                    </script>";
                    }
 
                   mysqli_close($conn);
				
			}
			else{
			  
			    
				//$em = "you can't upload files of this type!";
		       // header("location: login-register.html");
				echo "<script>
				   alert('you can not upload files of this type');
                   window.location.href='login-register.html';
					 </script>" ;
                    
			}
		
		}
		 
	 }
	 else{
		       $default_photo = "default.jpg";
		       $sql = "INSERT INTO `user`(`email`, `password`, `name`, `dob`, `profile_picture`,`user_type`) VALUES ('$email','$pass','$name','$date','$default_photo','$user_type')";
                $result = mysqli_query($conn, $sql);
               if($result)
                  {
                  	header("location: home.php");
                   }

               else
                  {
	                echo "<script>
                    alert('This Email Already Exits,Try another email ');
                    window.location.href='login-register.html';
                    </script>";
                    }
 
                   mysqli_close($conn);
		
	 }
 
}
else
 {   
    
	 header("location: login-register.html");  
 }




?>