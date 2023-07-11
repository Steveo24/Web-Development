 <?php
require_once('../Shared/db.php');
require_once('./styling.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$username='';
$password='';
$errorMsg='';

if(!empty($_REQUEST['b1'])){
    if(!empty($_REQUEST['email'])){
        $username = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $results = execute('SELECT * FROM admin WHERE email = ? AND password = ?',[$username, $password]);

        if (count($results) >= 1){
            $_SESSION['email'] = $_REQUEST['email'];
            $_SESSION['password'] = $_REQUEST['password'];
            $_SESSION['index']=true;
            $_SESSION['status']=$results[0]['status'];
            header("Location: index.php?page=welcome");

        }
        else{
            $errorMsg = "Invalid username or password, please try again.";
        }
    }
    else{
        $errorMsg = "Please enter a username and password.";
    }
}

?> 

<html>
    <body class="container">
        <form method="POST">
            <h1>Login</h1>
            <br>
            <div>
                <font color="red"><?=$errorMsg?></font>
                <br>
                <label for="email">Email</label>
                <div>
                <input type="email" id="email" class="input" name="email">
                </div>
            </div>
            <br>
            <div">
                <label for="password">Password</label>
                <div>
                <input type="password" id="password" class="input" name="password">
                </div>
            </div>
            <div>
            <br>
            <input type="submit" value="Login" class="button" name='b1'></input>
            </div>
        </form>
    </body>
</html>