<?php
//includes/classes/Constants.php

class Constants {

    //register error messages

    public static $passwordDontMatch = "Passwords don't match" ;
    public static $passwordAlphanumeric = "Password can take only numbers and letters" ;
    public static $passwordCharacters = "Password must be more than 6 and less than 15 characters" ;
    public static $usernameCharacters = "Username must be less than 25 and more than 5 characters" ;
    public static $usernameTaken = "This username already exists" ;
    public static $firstnameCharacters = "Firstname must be less than 25 and more than 2 characters" ;
    public static $lastnameCharacters = "Lastname must be less than 25 and more than 2 characters" ;
    public static $emailInvalid = "Invalid email format" ;
    public static $emailsDontMatch = "Emails don't match" ;
    public static $emailTaken = "This email is already in use" ;

    //login error messages
    public static $loginFailed = "The username or password does not exist in the database." ;

}
?>