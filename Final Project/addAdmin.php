<?
require_once('./styling.php');
require_once('../Shared/db.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['status'] == 'Staff'){
    header("Location: index.php?page=logout");
}

$inputName=''; $inputEmail=''; $inputPassword=''; $inputStatus='';
$nameValidation=''; $errorMsgName=''; $emailValidation=''; $errorMsgEmail=''; $errorMsgPassword=''; $passwordValidation='';
$adminAdded=FALSE; $successStructure=''; $successMsg=''; $duplicateAdmin=FALSE; $errorStructure=''; $errorMsg='';

if(!empty($_REQUEST['submitButton2'])){
    $inputName = $_REQUEST['inputName'];
    $inputEmail = $_REQUEST['inputEmail'];
    $inputPassword = $_REQUEST['inputPassword'];
    $inputStatus = $_REQUEST['inputStatus'];

    if(!empty($inputName)){
        $pattern = '/^([a-z]|-|\'|\s)+$/i';
         $nameValidation = preg_match($pattern,$inputName);
         if ($nameValidation == 0){
             $errorMsgName="Invalid Name: (Alpha characters (upper and lower case), hyphens, apostrophes, spaces only)";
         }
     }  else {   
        $errorMsgName="Invalid Name";
    }

    if(!empty($inputEmail)){
        $pattern = '/^[a-z0-9^@]+@[a-z0-9][a-z0-9\.]+\..+$/i';
        $emailValidation = preg_match($pattern, $inputEmail);
        if ($emailValidation == 0){
            $errorMsgEmail="Invalid Email Address: (Must be a valid email address)";
        }
    }
    else {   
        $errorMsgEmail="Invalid Email";
    }

    if(!empty($inputPassword)){
        $passwordValidation = 1;

    } else{
       $errorMsgPassword="Invalid Password";
    }

    if($nameValidation==1 && $emailValidation==1 && $passwordValidation==1){
        $sql = 'SELECT admin_id FROM admin WHERE email = ?';      //searching database if email address already exists
        $argArr=[];
        $argArr[] = $inputEmail;
        $results = execute($sql,$argArr);
        if(!empty($results)){   //if email address is found
            $duplicateAdmin=TRUE;
        } else{
            $sql = 'INSERT INTO admin (name,email,password,status) VALUES (?,?,?,?)';       //prepared statement inserts the file and contents into the database
            $argArr=[];
            $argArr[] = $inputName;
            $argArr[] = $inputEmail;
            $argArr[] = $inputPassword;
            $argArr[] = $inputStatus;
            execute($sql,$argArr);
            $adminAdded=TRUE;
        }
    }


    if ($adminAdded==TRUE){
        $successStructure=('class="alert alert-success" role="alert"');
        $successMsg="Admin added!";
     }
     if ($duplicateAdmin==TRUE){
        $errorStructure=('class="alert alert-danger" role="alert"');
        $errorMsg = ("Error! Admin's email address already exists: Cannot add admin.");
     }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Admin</title>
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
        <div class="container">
            <div class="mb-3">
                <label for="inputName" class="space">Name (letters only)</label>
                <div class="error"><?=$errorMsgName?></div>
                <input type="text" class="form-control" id="inputName" name="inputName" aria-describedby="userName">
            </div>
            <div class="mb-3">
                <label for="inputEmail" class="space">Email Address</label>
                <div class="error"><?=$errorMsgEmail?></div>
                <input type="email" class="form-control" id="inputEmail" name="inputEmail">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="space">Password</label>
                <div class="error"><?=$errorMsgPassword?></div>
                <input type="password" class="form-control" id="inputPassword" name="inputPassword">
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="inputStatus" class="form-select" aria-label="Default select example" >
                    <option selected value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <input type="submit" class="btn btn-primary" name="submitButton2" ></input>
            <br><br><br>
        </div>
</html>