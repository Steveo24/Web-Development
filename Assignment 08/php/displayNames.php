<?php
require_once('../../Shared/db.php');
//* Homework

/*
Read all the records from the 'names' table in name order.

if no data is found {
    create an array with two keys called 'msg', and 'masterstatus'.
    set the value for the 'masterstatus' key to 'error'.
    set the value of the 'msg' key to something like 'no data'.
} else {
    create a string that represents all the names in the table using '<br>' as your delimiter.
    create an array with 1 key called 'names', and set it's value to the string you created in the line above.    
}
Create a json encoded string from this array and echo it out.

Make sure your first line is the php start tag, and DO NOT use a php end tag!

*/

$readNames = execute('SELECT * FROM names ORDER BY name ASC');
$readNames = array_column($readNames, 'name');

if (empty($readNames))
{
    $ar=[];
    $ar['msg'] = 'no data';
    $ar['masterstatus'] = 'error'; 

}
else
{
    $string = implode("<br>", $readNames);
    $ar2=[];
    $ar2['names'] = $string;
}

$jsonStr = json_encode($ar2);
echo($jsonStr); 