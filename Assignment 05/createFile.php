<?
$fileName = '';
$fileContents='';
$dir='./files';
$filePath='';
if (!empty($_REQUEST['b1'])) {
    $fileContents = $_REQUEST['fileContents'];
    $fileName = $_REQUEST['fileName'];

    if (!file_exists($fileName)) {
        $fileName = $fileName . '.txt';
        $filePath = './files/' . $fileName;
        file_put_contents($filePath, $fileContents);
        touch("./files/$fileName");

    }
    else {
        echo "File exists, please rename file.";
    }
}

function getFiles() {
    $dir='./files';
    $files = scandir($dir);
    $files = array_diff($files, ['..', '.']);
    foreach ($files as $file) {
        echo "<a href='files/$file' target='somename'>$file</a><br>";
    }
}
?>

<html>
    <p>Enter file name and the file contents.<br>
    File names should contain alpha-numeric characters only. (No Spaces)</p>
    <form method='POST'>
        <label for="text">File Name</label>
        <br>
        <input type="text" name="fileName" value="<?=$fileName?>">
        <br><br>
        <label for="fileContent">File Contents</label>
        <br>
        <textarea name="fileContents"><?=$fileContents?></textarea>
        <br><br>
        <input type="submit" name='b1' value="Submit">
        <br>
        <hr>
        <?getFiles();?>
    </form>
</html>