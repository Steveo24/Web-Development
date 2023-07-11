<?php
require_once('../../Shared/db.php');
//* Homework

/*
The name the user input will be in the $_REQUEST superglobal.
The 'data' key in the request will be a string that is a json encoded array with the key 'name'.

So basically:
$userInputName = json_decode($_REQUEST['data'],true)['name'];

Now that you have $userInputName, create a 'lastname, firstname' string like we did in the past using explode.
Make sure you have both the last name and the first name.

If there are any errors {
    create an array with two keys called 'msg', and 'masterstatus'.
    set the value for the 'masterstatus' key to 'error'.
    set the value of the 'msg' key to whatever your error is.
} else {
    insert the 'lastname, firstname' string into the 'names' table.
    create an array with one key called 'msg'.
    set the value of the 'msg' key to some sort of success message.
}
Create a json encoded string from this array and echo it out.

Make sure your first line is the php start tag, and DO NOT use a php end tag!
*/
$userInputName = json_decode($_REQUEST['data'],true)['name'];

$lastFirst = explode(' ', $userInputName);
$lastFirst = array_reverse($lastFirst);
$name = implode(', ', $lastFirst);

if(!empty($lastFirst))
{
    if(count($lastFirst) < 2)
    {
        $arError=[];
        $arError['masterstatus'] = 'error'; 
        $arError['msg'] = 'Need first and last name';
    }
    else
    {
        $sql = 'INSERT INTO names (name) VALUES (?)';
        $arg=[];
        $arg[] = $name;
        execute($sql,$arg);
        $ar=[];
        $arError['msg'] = 'Name added';
    }
    $jsonStr = json_encode($arError);
    echo($jsonStr); 
}
