<?
$list='';
if (!empty($_REQUEST['b1'])) {
    $list = $_REQUEST['list'];
    $myname = $_REQUEST['myname'];
    $myname = switchName($myname);
    $ar = explode("\n", $list);
    $ar[] = $myname;
    asort($ar);
    $list = implode("\n", $ar);
}
else if (!empty($_REQUEST['b2'])) {
    $list='';
}
else {
    echo "must enter a name";
}

function switchName($myname) {
    $format = explode(" ",$myname);
    $newName = $format[1] . ',' . $format[0];
    return $newName;
}
?>

<html>
    <header>Add Names</header>
    <form method='POST'>
        <input type="submit" name='b1' value="Add name">
        <input type="submit" name='b2' value="Clear name">
        <br><br>
        <label for="text">Enter Name</label>
        <br>
        <input type="text" name="myname" >
        <br><br>
        <label for="list">List of Names</label>
        <br>
        <textarea readonly name="list"><?=$list?></textarea>
        <br><br>
    </form>
</html>