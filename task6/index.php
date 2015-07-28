<?php

include 'auth.php';

if (isAuth()){
    header("location: form.php");
}
else{
    if (isset($_POST['userid'])){
        // if they've tried and failed to log in
        echo 'Incorrect login or password. Try again<br><br>';
    }
    else{
        // they have not tried to log in yet or have logged out
        echo 'You are not logged. Please enter your e-mail and password.<br><br>';
    }
    // provide form to log in 
    include_once 'login_form.php';

}
