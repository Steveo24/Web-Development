<?php
require_once('../Shared/db.php');
if (!empty($_REQUEST['upload']))
{
    if (!empty($_FILES['myfile']['name']))
    {
        if ($_FILES['myfile']['type'] != 'text/plain')
        {
            echo("invalid file type");
        }
        else
        {
            $filename = $_FILES['myfile']['name'];
            $sql = 'SELECT a7id FROM a7 WHERE file_name = ?';
            $arg=[];
            $arg[] = $filename;
            $results = execute($sql,$arg);
            if (!empty($results))
            {
                echo("File name already exists");
            }
            else
            {
                $contents = file_get_contents($_FILES['myfile']['tmp_name']);
                $sql = 'INSERT INTO a7 (file_name, contents) VALUES (?,?)';
                $arg=[];
                $arg[] = $filename;
                $arg[] = $contents;
                execute($sql,$arg);
            }
        }
    }
    else
    {
        echo("Please select a file");
    }
}

$data = execute('SELECT file_name,contents FROM a7 ORDER BY file_name');

?>

<html>
<div>
    <form enctype="multipart/form-data" method="post">
        <input type="submit" value="Upload File" name="upload" />&nbsp;
        <input type="file" name="myfile" accept=".txt" />
        <br><br>
    </form>
    <hr>
    <?echo("Existing Files");?>
    <div>
        <table border="1" cellspacing="0" cellpadding="2"> 
            <? foreach ($data as $file) { ?>
            <tr>
                <td><? echo($file['file_name']);  ?></td>
                <td><? echo($file['contents']);  ?></td>
            </tr>
            <? } ?>
        </table>
    </div>
</div>
</html>