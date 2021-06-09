<?php

$msg = $_POST['msg'];
$btn = $_POST['btn'];
$email = $_GET['user_email'];
SESSION_START();
$user_type = $_SESSION['user_type'];

$msgtmp = $msg ;
if ( isset( $btn ) ) {

    $servername = "localhost";
    $username = "root";
    $password = "password";
    $db = "website";

    $conn = mysqli_connect( $servername, $username, $password, $db );
    if ( !$conn ) {

        die( "Connection failed: " . mysqli_connect_error() );

    }
    if ( $msg && $_FILES['my_image']['name'] ) {
        $img_name = $_FILES['my_image']['name'];
        $img_size = $_FILES['my_image']['size'];
        $tmp_name = $_FILES['my_image']['tmp_name'];
        $error = $_FILES['my_image']['error'];

        if ( $error == 0 )
        {

            $img_ex = pathinfo( $img_name, PATHINFO_EXTENSION );
            $img_ex_lc = strtolower( $img_ex );
            $allowed_exs = array( "jpg", "jpeg", "png" );

            if ( in_array( $img_ex_lc, $allowed_exs ) )
            {
                $new_img_name = uniqid( "IMG-", true ).'.'.$img_ex_lc ;
                $img_upload_path = '../IMG/'.$new_img_name ;
                move_uploaded_file( $tmp_name, $img_upload_path );

                $sql = "INSERT INTO `post` (`body`,`image`,`like_counter`,`owner_email`) VALUES ('$msg', '$new_img_name', '0', '$email')";
                $result = mysqli_query( $conn, $sql );
                if ( $result ) {
                    header( "location: home.php?user_email=$email" );
                }

            } else {
                echo "<script>
                    alert('you can not upload this type of file'); 
                    window.location.href='home.php?user_email=$email';
                    </script>";

            }

        }
        mysqli_close( $conn );
    }
    else if ( $msg ) {

        // echo "hello from text ";

        $sql = "INSERT INTO `post` (`body`,`like_counter`,`owner_email`) VALUES ('$msg','0', '$email')";
        $result = mysqli_query( $conn, $sql );
        if ( $result ) {
            header( "location: home.php?user_email=$email" );

        }

    } else {
        $img_name = $_FILES['my_image']['name'];
        $img_size = $_FILES['my_image']['size'];
        $tmp_name = $_FILES['my_image']['tmp_name'];
        $error = $_FILES['my_image']['error'];

        if ( $error == 0 )
        {

            $img_ex = pathinfo( $img_name, PATHINFO_EXTENSION );
            $img_ex_lc = strtolower( $img_ex );
            $allowed_exs = array( "jpg", "jpeg", "png" );

            if ( in_array( $img_ex_lc, $allowed_exs ) )
            {
                $new_img_name = uniqid( "IMG-", true ).'.'.$img_ex_lc ;
                $img_upload_path = '../IMG/'.$new_img_name ;
                move_uploaded_file( $tmp_name, $img_upload_path );

                $sql = "INSERT INTO `post` (`image`,`like_counter`,`owner_email`) VALUES ('$new_img_name', '0', '$email')";
                $result = mysqli_query( $conn, $sql );
                if ( $result ) {
                    header( "location: home.php?user_email=$email" );

                }

            } else {
                echo "<script>
                    alert('you can not upload this type of file'); 
                    window.location.href='home.php?user_email=$email';
                    </script>";

            }

        }
        mysqli_close( $conn );
    }

}

?>