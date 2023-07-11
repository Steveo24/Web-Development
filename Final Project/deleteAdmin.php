<?
require_once('./styling.php');
require_once('../Shared/db.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['status'] == 'Staff'){
    header("Location: index.php?page=logout");
}

$keys=[]; $adminDeleted=FALSE; $emptySelection=FALSE; 
$errorStructure=''; $errorMsg=''; $successStructure=''; $successMsg=''; $idsToDelete = [];

if(!empty($_REQUEST['deleteButton'])){
    if (!empty($_REQUEST['idsToDelete'])) {
        $keys = [];
        foreach ($_REQUEST['idsToDelete'] as $key=>$value) {
            $keys[] = $key;
        }
        $keysString = implode(", ", $keys);
        $sql= "DELETE FROM admin WHERE admin_id IN ($keysString)";
        execute($sql);
        
        $adminDeleted=TRUE;
    } else{
        $emptySelection=TRUE;
    }
}

$listAdmins = execute('SELECT * FROM admin ORDER BY admin_id');

if ($adminDeleted==TRUE){
    $successStructure=('class="alert alert-success" role="alert"');
    $successMsg="Admin(s) deleted.";
 }
 if ($emptySelection==TRUE){
    $errorStructure=('class="alert alert-danger" role="alert"');
    $errorMsg = ("Error! No admins selected.");
 }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delete Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
    <form method='POST'>
        <div class="container">
        <?require_once('menu.php');?>
            <br><br>
                <div <?=$successStructure?>>
                    <?=$successMsg?>
                </div>
                <div <?=$errorStructure?>>
                    <?=$errorMsg?>
                </div>
            <table class="table table-striped">
                <thead>
                <tr>
                        <th><label class="rowHeader" scope="col">Name</label></th>
                        <th><label class="rowHeader" scope="col">Email</label></th> 
                        <th><label class="rowHeader" scope="col">Password</label></th>
                        <th><label class="rowHeader" scope="col">Status</label></th>
                        <th><label class="rowHeader" scope="col">Select</label></th>
                    </tr>
                </thead>

                <? foreach ($listAdmins as $data) { ?>
                    <tr>
                        <td><? echo($data['name']);  ?></td>
                        <td><? echo($data['email']);  ?></td>
                        <td><? echo($data['password']);  ?></td>
                        <td><? echo($data['status']);?></td>
                        <td><input type="checkbox" name=idsToDelete[<?=$data['admin_id']?>]></td>
                    </tr>
                <? } ?>		
            </table>
            <input onclick="return confirm('Are you sure you want to delete these admin?');" type="submit" name="deleteButton" value="Delete" class="btn btn-danger">
        </div>
    </form>
</html>