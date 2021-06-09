<?php 


session_start();

unset($_SESSION);
Session_destroy();
header("location:login-register.html");




?>