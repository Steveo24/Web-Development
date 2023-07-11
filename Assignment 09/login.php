<?php
// The Login Page
// The log in page should have the following:
// An 'input type=text' element for the user name.
// An 'input type=password' element for the user password.
// An 'input type=submit' element for the log in button.
// When the user presses 'log in' search the login table for a match.
// If no match is found, display an error.
// If the user does not enter a user name or password, display an error.
// If a match is found, set the user name in the session and redirect to the 'search' page.


require_once('../Shared/db.php');
date_default_timezone_set('America/Detroit');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!empty($_REQUEST['b1'])) {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $hash = md5($password);
    $results = execute('SELECT * FROM login WHERE user_name = ? AND password_hash = ?',[$username, $hash]);
    if (!empty($results)) {
        $_SESSION['username'] = $username;
       header("Location: search.php");
    }
    else
    {
        echo('Username or Password is incorrect');
    }
}

?>

<html>
    <header>Please Log In</header>
    <br>
    <form method='POST'>
        <input type="text" name="username" placeholder="Username" >
        <br><br>
        <input type="password" name="password" placeholder="Password">
        <br><br>
        <input type="submit" name='b1' value="Log In">
    </form>
</html>