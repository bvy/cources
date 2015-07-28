<?php
    include_once 'auth.php';
  
    if (!isAuth()) {
    header("location: index.php"); 
    exit();  
}
    unset($_SESSION['validUser']);
    session_destroy();
    header("location: index.php");
