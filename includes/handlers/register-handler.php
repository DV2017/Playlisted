<?php
//includes/handlers/register-handler.php

function sanitizeFormUsername($inputText){
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ", "", $inputText);
    return $inputText;
}

function sanitizeFormString($inputText){
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ", "", $inputText);
    $inputText = ucfirst(strtolower($inputText));
    return $inputText;
}

function sanitizeFormPassword($inputText){
    $inputText = strip_tags($inputText);
    return $inputText;
}


if(isset($_POST['registerButton'])){
    //user registers and php calls the sanitize and register functions
    //the not_empty filter is not valide since 'required' clause in html takes care of empty form fields
    $username = sanitizeFormUsername($_POST['username']);
    $firstName = sanitizeFormString($_POST['firstName']);
    $lastName = sanitizeFormString($_POST['lastName']);
    $email = sanitizeFormUsername($_POST['email']);
    $email2 = sanitizeFormUsername($_POST['email2']);
    $password = sanitizeFormPassword($_POST['password']);
    $password2 = sanitizeFormPassword($_POST['password2']);

    //calls the register function here after creating a new class in register.php
    $wasSuccessful = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2); 

    if($wasSuccessful === true) {
        $_SESSION['userLoggedIn'] = $username;
        header("Location: index.php");
    }

}

?>