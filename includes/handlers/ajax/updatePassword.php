<?php
//includes/handlers/ajax/updatePassword.php
include("../../config.php");

if(!isset($_POST['username'])){
    echo "Could not set username";
    exit();
}

if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])) {
    echo "Not all passwords have been set";
    exit();
}

if($_POST['oldPassword'] == "" || $_POST['newPassword1'] == "" || $_POST['newPassword2'] == "") {
    echo "Please fill in all fields";
    exit();
}

$username = $_POST['username'];
$oldPassword = $_POST['oldPassword'];
$newPassword1 = $_POST['newPassword1'];
$newPassword2 = $_POST['newPassword2'];

$oldMd5 = md5($oldPassword);

//check for existing password
$passwordCheck = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password='$oldMd5' ");
if(mysqli_num_rows($passwordCheck) != 1) {
    echo "Password is incorrect";
    exit();
}
//confirm the 2 new passwords
if($newPassword1 != $newPassword2) {
    echo " Your passwords do not match";
    exit();
}

//check for pattern match
if(preg_match('/[^a-zA-Z0-9]/', $newPassword1)) {
    echo "Your passwords must contain only letters and numbers";
    exit();
}

//check for string length
if(strlen($newPassword1) > 30 || strlen($newPassword1) < 6 ) {
    echo " Your password must be between 5 and 30 characters";
    exit();
}

//set the password encrypted
$newMd5 = md5($newPassword1);

//update database
$query = mysqli_query($con, "UPDATE users SET password='$newMd5' WHERE username='$username' ");

echo "Password has been updated";
?>