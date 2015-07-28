<?php

include_once 'auth.php';

if (isAuth()){
    echo 'You are logged to site as: '.  getAuthUser().' <br />';
    echo '<form method="post" action="logout.php"><input type="submit" value="Log out"></form>';
}
 else {
    header("location: index.php"); 
    exit();
 }
?>

<html>
   <head>
        <title>File parser</title>    
    </head>
    <body>
        <h2>Import CSV</h2>
        <form action="csv.php" method="POST" enctype="multipart/form-data">
            <label>
                <input type="file" name="file">
            </label>
                      
            <br>
            <br>
            <input type="submit" name="submit"> 
        </form>
        <hr>
        <h2><a href="view.php">View products</a></h2>
    </body> 
</html>
