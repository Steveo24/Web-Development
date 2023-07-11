<?php
require_once('../Shared/db.php');
require_once('./styling.php');


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(empty($_SESSION['email'])) {
    header("Location: login.php");
}


$name=$_SESSION['email'];

require_once('menu.php');
?>

<html>
    <body class="container">
        
        <br><br>
        <h1>Welcome</h1>
        Welcome <b><font color="green"><?=$name?></font></b>    

    </body>
</html>
