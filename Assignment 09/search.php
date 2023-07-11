<?php
// The Search Page
// If the user attempts to access this page without having previously logged in, redirect them to the log in page.
// At the top of the this page, you are to display the logged in user's name.
// You will have 3 html elements in your form on this page.
// Two 'input type=datetime-local' elements to select the starting and ending date.
// An 'input type=submit' element for the 'get notes' button.
// There are no error messages on this page.
// If the button is pressed, and both dates are entered, search the a9 table for matching records.
// If any records are found, display in an html table.
// The date data read from the database should be displayed in a human readable format.

require_once('../Shared/db.php');
date_default_timezone_set('America/Detroit');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(empty($_SESSION['username'])) {
    header("Location: login.php");
}

$results = [];
$d1 = "";
$d2 = "";

if(!empty($_REQUEST['d1'])) {
    $d1 = $_REQUEST['d1'];
}

if(!empty($_REQUEST['d2'])) {
    $d2 = $_REQUEST['d2'];
}

if(!empty($_REQUEST['d1']) && !empty($_REQUEST['d2'])) {
    $results = execute('SELECT * FROM a9 WHERE saved > ? AND saved < ?', [$_REQUEST['d1'], $_REQUEST['d2']]);
}

function convertD($d) {
     $phpdate = strtotime( $d ); 
     return date( 'm/d/Y h:i A', $phpdate ); 
    } 
?>

<html>
    <form method="post">
        <header> Logged in as <?=$_SESSION['username']?></header>
        <hr>
        <br><br>
        <div>Beginning Date</div>
        <input type="datetime-local" name="d1" value="<?=$d1?>">
        <br><br>
        <div>Ending Date</div>
        <input type="datetime-local" name="d2" value="<?=$d2?>">
        <br><br>
        <input type="submit" name="mybutton" value="Get Data">
        <br>
        <table border="1" cellpadding="3" cellspacing="0">
            <? foreach ($results as $result) { ?>
                <tr>
                    <td><?=$result['note']?></td>
                    <td><?=convertD($result['saved'])?></td>
                </tr>
            <? } ?>
        </table> 
    </form>
</html>