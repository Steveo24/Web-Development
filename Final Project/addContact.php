<?
require_once('./styling.php');
require_once('../Shared/db.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(empty($_SESSION['email'])) {
    header("Location: login.php");
}

$errorMsgName=''; $errorMsgAdd=''; $errorMsgCity=''; $errorMsgPhone=''; $errorMsgEmail=''; $errorMsgDOB='';

$inputName=''; $inputAddress=''; $inputCity=''; $inputPhone=''; $inputEmailContact=''; $inputDOB=''; 

$inputState=array(); $contactTypes=[];

$nameValidation=''; $addressValidation=''; $cityValidation=''; $phoneValidation=''; $emailValidation=''; $dobValidation='';
$contactAdded=FALSE; $successStructure=''; $successMsg=''; $duplicateContact=FALSE; $errorStructure=''; $errorMsg='';

$cb1=!empty($_REQUEST['cb1']); $cb2=!empty($_REQUEST['cb2']); $cb3=!empty($_REQUEST['cb3']);


if(!empty($_REQUEST['submitButton3'])){     
    $inputName=$_REQUEST['inputName'];
    $inputAddress=$_REQUEST['inputAddress'];
    $inputCity=$_REQUEST['inputCity'];
    $inputState=$_REQUEST['inputState'];
    $inputPhone=$_REQUEST['inputPhone'];
    $inputEmailContact=$_REQUEST['inputEmailContact'];
    $inputDOB=$_REQUEST['inputDOB'];

    if(!empty($inputName)){
       $pattern = '/^([a-z]|-|\'|\s)+$/i';
        $nameValidation = preg_match($pattern,$inputName);
        if ($nameValidation == 0){
            $errorMsgName="Invalid Name: (Alpha characters (upper and lower case), hyphens, apostrophes, spaces only)";
        }
    }
    else {   
        $errorMsgName="Invalid Name";
    }

    if(!empty($inputAddress)){
        $pattern = '/^\d+\s(\.|-|[a-z]|\s)+$/i';
        $addressValidation = preg_match($pattern, $inputAddress);
        if ($addressValidation == 0){
            $errorMsgAdd="Invalid Address: (Start with a number, then alpha characters, spaces, hyphens, or periods)";
        }
    }
    else {   
        $errorMsgAdd="Invalid Address";
    }

    if(!empty($inputCity)){
        $pattern = '/^[a-z\s]+$/i';
        $cityValidation = preg_match($pattern, $inputCity);
        if ($cityValidation == 0){
            $errorMsgCity="Invalid City: (Must be alpha characters only)";
        }
    }
    else {   
        $errorMsgCity="Invalid City";
    }

    if(!empty($inputState)){
       $inputStateStr = implode(" ", $inputState);
    }

    if(!empty($inputPhone)){
        $pattern = '/^\d{3}\.\d{3}\.\d{4}$/';
        $phoneValidation = preg_match($pattern, $inputPhone);
        if ($phoneValidation == 0){
            $errorMsgPhone="Invalid Phone Number: (Must be in the format 999.999.9999, where 9 is a digit of 0 to 9)";
        }
    }
    else {   
        $errorMsgPhone="Invalid Phone Number";
    }

    if(!empty($inputEmailContact)){
        $pattern = '/^[a-z0-9^@]+@[a-z0-9][a-z0-9\.]+\..+$/i';
        $emailValidation = preg_match($pattern, $inputEmailContact);
        if ($emailValidation == 0){
            $errorMsgEmail="Invalid Email Address: (Must be a valid email address)";
        }
    }
    else {   
        $errorMsgEmail="Invalid Email";
    }

    if(!empty($inputDOB)){
        $dobValidation = 1;
    }
    else {   
        $errorMsgDOB="Invalid Date of Birth";
    }

    if (!empty($_POST['cb1'])) {
        $cb1=$_REQUEST['cb1'];
        $contactTypes[]=$cb1;
    }
    if (!empty($_POST['cb2'])) {
        $cb2=$_REQUEST['cb2'];
        $contactTypes[]=$cb2;
    }
    if (!empty($_POST['cb3'])) {
        $cb3=$_REQUEST['cb3'];
        $contactTypes[]=$cb3;
    }
    $contactTypesString=implode(", ", $contactTypes);

    if($nameValidation==1 && $addressValidation==1 && $cityValidation==1 && $phoneValidation==1 && $emailValidation==1 && $dobValidation==1){
        $sql = 'SELECT contact_id FROM contact WHERE email = ?';      //searching database if email address already exists
        $argArr=[];
        $argArr[] = $inputEmailContact;
        $results = execute($sql,$argArr);
        if(!empty($results)){   //if email address is found
            $duplicateContact=TRUE;
        } else{
            $sql = 'INSERT INTO contact (name,address,city,phone,state,dob,email,contact) VALUES (?,?,?,?,?,?,?,?)';       //prepared statement inserts the file and contents into the database
            $argArr=[];
            $argArr[] = $inputName;
            $argArr[] = $inputAddress;
            $argArr[] = $inputCity;
            $argArr[] = $inputPhone;
            $argArr[] = $inputStateStr;
            $argArr[] = $inputDOB;
            $argArr[] = $inputEmailContact;
            $argArr[] = $contactTypesString;
            execute($sql,$argArr);
            $contactAdded=TRUE;
        }
    }
 }

 if ($contactAdded==TRUE){
    $successStructure=('class="alert alert-success" role="alert"');
    $successMsg="Contact added!";
 }

 if ($duplicateContact==TRUE){
    $errorStructure=('class="alert alert-danger" role="alert"');
    $errorMsg = ("Error! Email address already exists: Cannot add contact.");
 }

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Contact</title>
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
                <div class="mb-3">
                    <label for="inputName" class="space">Name (letters only)</label>
                    <div class="error"><?=$errorMsgName?></div>
                    <input type="text" class="form-control" id="inputName" value="<?=$inputName?>" name="inputName" aria-describedby="userName">
                </div>
                <div class="mb-3">
                    <label for="inputAddress" class="space">Address (number and street)</label>
                    <div class="error"><?=$errorMsgAdd?></div>
                    <input type="addresss" class="form-control" id="inputAddress" value="<?=$inputAddress?>" name="inputAddress" value>
                </div>
                <div class="mb-3">
                    <label for="inputCity" class="space">City</label>
                    <div class="error"><?=$errorMsgCity?></div>
                    <input type="text" class="form-control" id="inputCity" value="<?=$inputCity?>" name="inputCity">
                </div>
                <div class="mb-3">
                    <label for="inputState" class="space">State</label>
                    <select name="inputState[]" value="<?=$inputState?>" class="form-control" aria-label="Default select example">
                        <option selected value="Michigan" <? echo(in_array('Michigan',$inputState) ? 'selected' : ''); ?>>Michigan</option>
                        <option value="Indiana" <? echo(in_array('Indiana',$inputState) ? 'selected' : ''); ?>>Indiana</option>
                        <option value="Illinois" <? echo(in_array('Illinois',$inputState) ? 'selected' : ''); ?>>Illinois</option>
                        <option value="Ohio" <? echo(in_array('Ohio',$inputState) ? 'selected' : ''); ?>>Ohio</option>
                        <option value="New York" <? echo(in_array('New York',$inputState) ? 'selected' : ''); ?>>New York</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="inputPhone" class="space">Phone</label>
                    <div class="error"><?=$errorMsgPhone?></div>
                    <input type="text" class="form-control" id="inputPhone" value="<?=$inputPhone?>" name="inputPhone">
                </div>
                <div class="mb-3">
                    <label for="inputEmailContact" class="space">Email</label>
                    <div class="error"><?=$errorMsgEmail?></div>
                    <input type="email" class="form-control" id="inputEmailContact" value="<?=$inputEmailContact?>" name="inputEmailContact">
                </div>
                <div class="mb-3">
                    <label for="dob" class="space">Date of birth</label>
                    <div class="error"><?=$errorMsgDOB?></div>
                    <input type="date" class="form-control" value="<?=$inputDOB?>" name="inputDOB" id="dob">
                </div>
                <div class="mb-3">
                    Please check all contact types you would like (optional):<br>
                    <input type="checkbox" id="cb1" name="cb1" value="Newsletter" <? echo($cb1 ? 'checked' : ''); ?>>
                    <label for="cb1"> Newsletter</label>&nbsp;&nbsp;
                    <input type="checkbox" id="cb2" name="cb2" value="Email Updates" <? echo($cb2 ? 'checked' : ''); ?>>
                    <label for="cb2"> Email Updates</label>&nbsp;&nbsp;
                    <input type="checkbox" id="cb3" name="cb3" value="Text Updates" <? echo($cb3 ? 'checked' : ''); ?>>
                    <label for="cb3"> Text Updates</label>&nbsp;&nbsp;
			    </div>
            <input type="submit" class="button" value="Submit" name="submitButton3" ></input>
            <br><br><br><br>
        </div>
</html>