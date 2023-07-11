<?php
require_once('../../Shared/db.php');
//* Homework

/*
Delete all the records from the 'names' table.

Create an array with one key called 'msg'.
Set the value of your 'msg' key to some sore of success message.
Create a json encoded string from this array and echo it out.

Make sure your first line is the php start tag, and DO NOT use a php end tag!

*/

$delete = execute('DELETE FROM names');
$ar=[];
$ar['msg'] = 'records deleted';
echo(json_encode($ar));