<?php
session_start();

if (isset($_POST['userid']) && isset($_POST['password']))
{
    // if the user has just tried to log in
    $userid = $_POST['userid'];
    $password = $_POST['password'];

    if (auth($userid, $password)){
        $_SESSION['validUser'] = $userid;    
    }
}


/*
 * check is combination user-password in pswd.ini file
 */
function auth($user, $pass){
 
    $array= readPasswordFile(__DIR__."/pswd.ini");
    foreach ($array as $key => $value) {
        if ($user == $key && md5($pass) == $value){
            $_SESSION['validUser'] = $user;
            return true;    
        }
        else{
            return false;
        }
    } 
}
 


function isAuth(){
    return isset( $_SESSION['validUser'])? true : false;
}

/*
 * return name of auth. user
 */
 function getAuthUser(){
   $name = $_SESSION['validUser']; 
   return isset($name) ?  substr($name,0,strpos($name, "@")) : false;
}
 
/*
 * read password file and return array name-password
 */
function readPasswordFile($patch){
    $array = file($patch);
    foreach ($array as $key => $value) {
        $line = explode(":", trim($value));
        $userPassword[$line[0]]=$line[1];
        return $userPassword;
    }   
}



 


