<?php
//includes/classes/Account.php

    class Account {
        private $con;
        private $errorArray;

        public function __construct($con) {
            //this refers to the instance of this class
            $this->con = $con;
            $this->errorArray = array();
        }

        public function login($un, $pw) {
            $pw = md5($pw);

            $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$un' AND password='$pw'");

            if(mysqli_num_rows($query) == 1) {
                return true;
            } else {
                array_push($this->errorArray, Constants::$loginFailed);
                return false;
            }
            
        }

        public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {
            $this->validateUsername($un);
            $this->validateFirstname($fn);
            $this->validateLastname($ln);
            $this->validateEmails($em, $em2);
            $this->validatePasswords($pw, $pw2);

            if(empty($this->errorArray) === true) {
                //insert into db
                return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
            } else {
                return false;
            }
        }

        public function getError($error) {
            if(!in_array($error, $this->errorArray)) {
                $error = "";
            }
            return "<span class='errorMessage'>$error</span>";
        } 

        private function insertUserDetails($un, $fn, $ln, $em, $pw){
            $encryptedPw = md5($pw);
            $profilePic = "assets/images/profile-pics/profile-pic.jpeg";
            $date = date("Y-m-d");

            # for error debug: echo "INSERT INTO users VALUES ($un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic'";
            $dataIn = "INSERT INTO users VALUES (0, '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')";  

            $result = mysqli_query($this->con, $dataIn);
            return $result;
        }

        #To-think-of : client side real-time error validation
        private function validateUsername($un){
            //length is suitable
            if(strlen($un) > 25 || strlen($un) < 5){
                array_push($this->errorArray, Constants::$usernameCharacters);
                return;
            }
            //check if username exists
            $queryUsername = "SELECT username FROM users WHERE username='$un'";
            $checkUsernameExists = mysqli_query($this->con, $queryUsername);
            if(mysqli_num_rows($checkUsernameExists) != 0) {
                array_push($this->errorArray, Constants::$usernameTaken);
                return;
            }

        }
        private function validateFirstname($fn){
            if(strlen($fn) > 25 || strlen($fn) < 2){
                array_push($this->errorArray, Constants::$firstnameCharacters);
                return;
            }
        
        }
        private function validateLastname($ln){
            if(strlen($ln) > 25 || strlen($ln) < 2){
                array_push($this->errorArray, Constants::$lastnameCharacters);
                return;
            }
        }
        private function validateEmails($em, $em2) {
            if($em != $em2) {
                array_push($this->errorArray, Constants::$emailsDontMatch);
                return;
            }

            if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
                array_push($this->errorArray, Constants::$emailInvalid);
                return;
            }
            //check that email is not already used 
            $queryEmail = "SELECT email FROM users WHERE email='$em'";
            $checkEmailExists = mysqli_query($this->con, $queryEmail);
            if(mysqli_num_rows($checkEmailExists) != 0) {
                array_push($this->errorArray, Constants::$emailTaken);
                return;
            }
 
        }
        private function validatePasswords($pw, $pw2){
            if($pw != $pw2) {
                array_push($this->errorArray, Constants::$passwordDontMatch);
                return;
            }
            //check for alphanumeric characters
            if(preg_match('/[^A-Za-z0-9]/', $pw)){
                array_push($this->errorArray, Constants::$passwordAlphanumeric);
                return;
            }
            if(strlen($pw) > 15 || strlen($pw) < 6){
                array_push($this->errorArray, Constants::$passwordCharacters);
                return;
            }
        }
    }
?>