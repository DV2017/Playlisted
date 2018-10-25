<?php
//register.php
    include("includes/config.php");
    include("includes/classes/Account.php");
    include("includes/classes/Constants.php");
    
    $account = new Account($con);
    
    include("includes/handlers/register-handler.php");
    include("includes/handlers/login-handler.php");

    function getInputValue($name){
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Spotify course</title>
    <link rel="stylesheet" href="assets/css/register.css">

    <script src="assets/js/jquery-3.2.1.js"></script>
    <script src="assets/js/register.js"></script>
</head>
<body>


  <?php 
  
        if(isset($_POST['registerButton'])){
            echo '<script>
                $(document).ready(function(){
                    $("#loginForm").hide();
                    $("#registerForm").show();
                });
            </script>';
        } else {
            echo '<script>
                $(document).ready(function(){
                    $("#loginForm").show();
                    $("#registerForm").hide();
                });
            </script>';
        }

    ?>

    <div id="background">
        <div id="loginContainer">
            <div id="inputContainer">
                <form action="register.php" id="loginForm" method="POST">
                    <h2>Login to your account.</h2>
                    <p>
                    <label for="loginUsername">User name: </label> 
                    <input type="text" id="loginUsername" name="loginUsername" placeholder="e.g. deepaVarma" value = "<?php getInputValue('loginUsername') ?>" required>        
                    <?php echo $account->getError(Constants::$loginFailed);?>
                    </p>
                    <p>
                    <label for="loginPassword">Password: </label>
                    <input type="password" id="loginPassword" name="loginPassword" placeholder="your password" required>      
                    </p>
                    <button type="submit" id="loginButton" name="loginButton">LOG IN</button>
                    <div class="hasAccountText">
                        <span id="hideLogin">Don't have an account? Register here.</span>
                    </div>
                </form>


                <form action="register.php" id="registerForm" method="POST">
                    <h2>Create your free account</h2>
                    <p>
                    <label for="username">User name </label> 
                    <input type="text" id="username" name="username" placeholder="e.g. deepavarma" value = "<?php getInputValue('username') ?>" required>   
                    <?php echo $account->getError(Constants::$usernameCharacters);?>     
                    <?php echo $account->getError(Constants::$usernameTaken);?>     
                </p>

                    <p>
                    <label for="firstName">First name </label> 
                    <input type="text" id="firstName" name="firstName" placeholder="e.g. Deepa" value = "<?php getInputValue('firstName') ?>"required>
                    <?php echo $account->getError(Constants::$firstnameCharacters);?>        
                    </p>

                    <p>
                    <label for="lastName">Last name </label> 
                    <input type="text" id="lastName" name="lastName" placeholder="e.g. Varma" value = "<?php getInputValue('lastName') ?>"required> 
                    <?php echo $account->getError(Constants::$lastnameCharacters);?>        
                    </p>

                    <p>
                    <label for="email">Email </label> 
                    <input type="email" id="email" name="email" placeholder="e.g. me@example.com" value = "<?php getInputValue('email') ?>"required> 
                    <?php echo $account->getError(Constants::$emailInvalid); ?>
                    <?php echo $account->getError(Constants::$emailsDontMatch); ?>      
                    <?php echo $account->getError(Constants::$emailTaken);?>     
                    </p>

                    <p>
                    <label for="email2">Confirm Email </label> 
                    <input type="email" id="email2" name="email2" placeholder="confirm email" value = "<?php getInputValue('email2') ?>"required>
                    </p>

                    <p>
                    <label for="password">Password </label>
                    <input type="password" id="password" name="password" placeholder="your password" required>  
                    <?php echo $account->getError(Constants::$passwordAlphanumeric); ?>   
                    <?php echo $account->getError(Constants::$passwordCharacters); ?>  
                    <?php echo $account->getError(Constants::$passwordDontMatch); ?> 
                    </p>

                    <p>
                    <label for="password2">Confirm Password </label>
                    <input type="password" id="password2" name="password2" placeholder="confirm password" required>   
                    </p>

                    <button type="submit" id="registerButton" name="registerButton">SIGN UP</button>
                    <div class="hasAccountText">
                        <span id="hideRegister">Already have an account? Login here.</span>
                    </div>

                </form>
            </div> <!-- input container -->
            <div id="loginText">
                <h1>Get your own music</h1>
                <h2>Get them free !!</h2>
                <ul>
                    <li>Discover</li>
                    <li>Enjoy</li>
                    <li>Sing along</li>
                </ul>
            </div>
        </div><!--loginContainer -->
    </div> <!--background-->

</body>
</html>